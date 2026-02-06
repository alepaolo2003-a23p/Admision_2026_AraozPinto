<?php
// admin/index.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();

// Obtener estadísticas
$stats = [
    'total_postulantes' => 0,
    'inscripciones_pendientes' => 0,
    'inscripciones_completadas' => 0,
    'examenes_programados' => 0,
    'postulantes_hoy' => 0
];

// Total postulantes
$stmt = $db->query("SELECT COUNT(*) as total FROM postulantes");
$stats['total_postulantes'] = $stmt->fetch()['total'];

// Inscripciones pendientes
$stmt = $db->query("SELECT COUNT(*) as total FROM postulantes WHERE estado_inscripcion = 'pendiente'");
$stats['inscripciones_pendientes'] = $stmt->fetch()['total'];

// Inscripciones completadas
$stmt = $db->query("SELECT COUNT(*) as total FROM postulantes WHERE estado_inscripcion = 'completado'");
$stats['inscripciones_completadas'] = $stmt->fetch()['total'];

// Exámenes programados
$stmt = $db->query("SELECT COUNT(*) as total FROM examenes_admision WHERE estado = 'programado'");
$stats['examenes_programados'] = $stmt->fetch()['total'];

// Postulantes de hoy
$stmt = $db->query("SELECT COUNT(*) as total FROM postulantes WHERE DATE(fecha_registro) = CURDATE()");
$stats['postulantes_hoy'] = $stmt->fetch()['total'];

// Últimos postulantes
$sql = "SELECT p.id, p.nombres, p.apellidos, p.dni, p.email, p.fecha_registro, 
        p.estado_inscripcion, prog.nombre as programa
        FROM postulantes p
        LEFT JOIN opciones_carrera oc ON p.id = oc.postulante_id AND oc.orden_preferencia = 'primera'
        LEFT JOIN programas_estudio prog ON oc.programa_id = prog.id
        ORDER BY p.fecha_registro DESC
        LIMIT 10";
$ultimos_postulantes = $db->query($sql)->fetchAll();

// Distribución por carreras
$sql = "SELECT prog.nombre, COUNT(*) as total 
        FROM opciones_carrera oc
        INNER JOIN programas_estudio prog ON oc.programa_id = prog.id
        WHERE oc.orden_preferencia = 'primera'
        GROUP BY prog.nombre
        ORDER BY total DESC";
$carreras_stats = $db->query($sql)->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-download"></i> Exportar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total Postulantes</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['total_postulantes']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Pendientes</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['inscripciones_pendientes']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Completadas</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['inscripciones_completadas']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Hoy</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['postulantes_hoy']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos y tablas -->
            <div class="row">
                <!-- Distribución por carreras -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-bar-chart-fill"></i> Distribución por Carreras</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="carrerasChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Inscripciones por estado -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Estado de Inscripciones</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="estadoChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimos postulantes -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill"></i> Últimos Postulantes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>DNI</th>
                                    <th>Email</th>
                                    <th>Programa</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ultimos_postulantes as $postulante): ?>
                                <tr>
                                    <td><?php echo $postulante['id']; ?></td>
                                    <td><?php echo $postulante['nombres'] . ' ' . $postulante['apellidos']; ?></td>
                                    <td><?php echo $postulante['dni']; ?></td>
                                    <td><?php echo $postulante['email']; ?></td>
                                    <td><?php echo $postulante['programa'] ?? 'Sin programa'; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($postulante['fecha_registro'])); ?></td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($postulante['estado_inscripcion']) {
                                            case 'pendiente': $badge_class = 'bg-warning'; break;
                                            case 'completado': $badge_class = 'bg-success'; break;
                                            case 'rechazado': $badge_class = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($postulante['estado_inscripcion']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="postulantes.php?id=<?php echo $postulante['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de carreras
const carrerasData = <?php echo json_encode($carreras_stats); ?>;
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

// Gráfico de estado
const estadoCtx = document.getElementById('estadoChart').getContext('2d');
new Chart(estadoCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pendientes', 'Completadas', 'Rechazadas'],
        datasets: [{
            data: [
                <?php echo $stats['inscripciones_pendientes']; ?>,
                <?php echo $stats['inscripciones_completadas']; ?>,
                0
            ],
            backgroundColor: ['#ffc107', '#28a745', '#dc3545']
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
</script>

<?php include 'includes/footer.php'; ?>