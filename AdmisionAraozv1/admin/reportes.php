<?php
// admin/reportes.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();

// Estadísticas generales
$stats = [];

// Total postulantes por mes
$sql = "SELECT DATE_FORMAT(fecha_registro, '%Y-%m') as mes, COUNT(*) as total 
        FROM postulantes 
        WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY mes
        ORDER BY mes";
$postulantes_mes = $db->query($sql)->fetchAll();

// Postulantes por carrera
$sql = "SELECT prog.nombre, COUNT(*) as total 
        FROM opciones_carrera oc
        INNER JOIN programas_estudio prog ON oc.programa_id = prog.id
        WHERE oc.orden_preferencia = 'primera'
        GROUP BY prog.nombre
        ORDER BY total DESC";
$por_carrera = $db->query($sql)->fetchAll();

// Postulantes por turno
$sql = "SELECT turno, COUNT(*) as total 
        FROM opciones_carrera
        WHERE orden_preferencia = 'primera'
        GROUP BY turno";
$por_turno = $db->query($sql)->fetchAll();

// Postulantes por edad
$sql = "SELECT 
        CASE 
            WHEN edad < 18 THEN 'Menor de 18'
            WHEN edad BETWEEN 18 AND 20 THEN '18-20 años'
            WHEN edad BETWEEN 21 AND 25 THEN '21-25 años'
            WHEN edad > 25 THEN 'Mayor de 25'
        END as rango_edad,
        COUNT(*) as total
        FROM postulantes
        GROUP BY rango_edad
        ORDER BY total DESC";
$por_edad = $db->query($sql)->fetchAll();

// Postulantes por nivel educativo
$sql = "SELECT grado_actual, COUNT(*) as total 
        FROM informacion_academica
        GROUP BY grado_actual
        ORDER BY total DESC";
$por_nivel = $db->query($sql)->fetchAll();

// Estado de pagos
$sql = "SELECT 
        SUM(CASE WHEN pago_realizado = 1 THEN 1 ELSE 0 END) as pagados,
        SUM(CASE WHEN pago_realizado = 0 THEN 1 ELSE 0 END) as pendientes,
        SUM(CASE WHEN pago_realizado = 1 THEN monto_pagado ELSE 0 END) as total_recaudado
        FROM inscripciones_examen";
$pagos = $db->query($sql)->fetch();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-graph-up"></i> Reportes y Estadísticas</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportarReporte()">
                            <i class="bi bi-download"></i> Exportar Reporte
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Imprimir
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de resumen -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-cash-coin"></i> Resumen de Pagos</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <h3 class="text-success"><?php echo $pagos['pagados']; ?></h3>
                                    <small class="text-muted">Pagados</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-warning"><?php echo $pagos['pendientes']; ?></h3>
                                    <small class="text-muted">Pendientes</small>
                                </div>
                                <div class="col-4">
                                    <h3 class="text-primary">S/. <?php echo number_format($pagos['total_recaudado'], 2); ?></h3>
                                    <small class="text-muted">Recaudado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-people-fill"></i> Postulantes por Edad</h6>
                        </div>
                        <div class="card-body">
                            <?php foreach ($por_edad as $edad): ?>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?php echo $edad['rango_edad']; ?></span>
                                    <span class="badge bg-primary"><?php echo $edad['total']; ?></span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" style="width: <?php echo ($edad['total'] / array_sum(array_column($por_edad, 'total')) * 100); ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-bar-chart-fill"></i> Postulantes por Carrera</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="carrerasChart" height="80"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Postulantes por Turno</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="turnoChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tendencia mensual -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-graph-up-arrow"></i> Tendencia de Inscripciones (Últimos 6 meses)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="tendenciaChart" height="60"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de nivel educativo -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-mortarboard-fill"></i> Distribución por Nivel Educativo</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nivel Educativo</th>
                                            <th>Cantidad</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_nivel = array_sum(array_column($por_nivel, 'total'));
                                        $niveles = [
                                            'secundaria_incompleta' => 'Educación Secundaria Incompleta',
                                            'secundaria_completa' => 'Educación Secundaria Completa',
                                            'tecnica_curso' => 'Educación Técnica en Curso',
                                            'tecnica_completa' => 'Educación Técnica Completa',
                                            'tecnica_incompleta' => 'Educación Técnica Incompleta',
                                            'universitaria_curso' => 'Educación Universitaria en Curso',
                                            'universitaria_completa' => 'Educación Universitaria Completa',
                                            'universitaria_incompleta' => 'Educación Universitaria Incompleta'
                                        ];
                                        foreach ($por_nivel as $nivel): 
                                            $porcentaje = ($nivel['total'] / $total_nivel) * 100;
                                        ?>
                                        <tr>
                                            <td><?php echo $niveles[$nivel['grado_actual']] ?? $nivel['grado_actual']; ?></td>
                                            <td><?php echo $nivel['total']; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                        <div class="progress-bar bg-primary" style="width: <?php echo $porcentaje; ?>%">
                                                            <?php echo number_format($porcentaje, 1); ?>%
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de carreras
const carrerasData = <?php echo json_encode($por_carrera); ?>;
const carrerasCtx = document.getElementById('carrerasChart').getContext('2d');
new Chart(carrerasCtx, {
    type: 'bar',
    data: {
        labels: carrerasData.map(item => item.nombre),
        datasets: [{
            label: 'Postulantes',
            data: carrerasData.map(item => item.total),
            backgroundColor: '#006b3f',
            borderColor: '#004d2e',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Gráfico de turnos
const turnoData = <?php echo json_encode($por_turno); ?>;
const turnoCtx = document.getElementById('turnoChart').getContext('2d');
new Chart(turnoCtx, {
    type: 'doughnut',
    data: {
        labels: turnoData.map(item => item.turno.charAt(0).toUpperCase() + item.turno.slice(1)),
        datasets: [{
            data: turnoData.map(item => item.total),
            backgroundColor: ['#006b3f', '#ff8c42']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de tendencia
const tendenciaData = <?php echo json_encode($postulantes_mes); ?>;
const tendenciaCtx = document.getElementById('tendenciaChart').getContext('2d');
new Chart(tendenciaCtx, {
    type: 'line',
    data: {
        labels: tendenciaData.map(item => {
            const [year, month] = item.mes.split('-');
            const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
            return monthNames[parseInt(month) - 1] + ' ' + year;
        }),
        datasets: [{
            label: 'Inscripciones',
            data: tendenciaData.map(item => item.total),
            borderColor: '#006b3f',
            backgroundColor: 'rgba(0, 107, 63, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5
                }
            }
        }
    }
});

function exportarReporte() {
    alert('Funcionalidad de exportación en desarrollo');
}
</script>

<?php include 'includes/footer.php'; ?>