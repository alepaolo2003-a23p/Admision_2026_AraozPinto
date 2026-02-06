<?php
// admin/lista_asistencia.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$examen_id = $_GET['id'] ?? 0;
$db = conectarDB();

// Obtener información del examen
$stmt = $db->prepare("SELECT * FROM examenes_admision WHERE id = ?");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$examen) {
    header('Location: examenes.php');
    exit;
}

// Obtener lista de postulantes
$sql = "SELECT p.*, ie.codigo_inscripcion, ie.pago_realizado, 
        prog.nombre as programa, oc.turno
        FROM inscripciones_examen ie
        INNER JOIN postulantes p ON ie.postulante_id = p.id
        LEFT JOIN opciones_carrera oc ON p.id = oc.postulante_id AND oc.orden_preferencia = 'primera'
        LEFT JOIN programas_estudio prog ON oc.programa_id = prog.id
        WHERE ie.examen_id = ?
        ORDER BY p.apellidos, p.nombres";

$stmt = $db->prepare($sql);
$stmt->execute([$examen_id]);
$postulantes = $stmt->fetchAll();

include 'includes/header.php';
?>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white;
    }
    
    .sidebar, .navbar {
        display: none !important;
    }
    
    main {
        margin-left: 0 !important;
        margin-top: 0 !important;
    }
    
    .card {
        box-shadow: none;
        border: 1px solid #000;
    }
    
    table {
        font-size: 10pt;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="sidebar no-print">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom no-print">
                <h1 class="h2"><i class="bi bi-list-check"></i> Lista de Asistencia</h1>
                <div class="btn-toolbar">
                    <a href="ver_examen.php?id=<?php echo $examen_id; ?>" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>

            <!-- Encabezado -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3>INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO</h3>
                        <h4>MARÍA ROSARIO ARAOZ PINTO</h4>
                        <h5 class="mt-3">LISTA DE ASISTENCIA - EXAMEN DE ADMISIÓN</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Código de Examen:</strong> <?php echo $examen['codigo_examen']; ?></p>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($examen['fecha_examen'])); ?></p>
                            <p><strong>Hora:</strong> <?php echo date('H:i', strtotime($examen['hora_inicio'])); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Aula:</strong> <?php echo $examen['aula'] ?: 'No asignada'; ?></p>
                            <p><strong>Duración:</strong> <?php echo $examen['duracion_minutos']; ?> minutos</p>
                            <p><strong>Total Inscritos:</strong> <?php echo count($postulantes); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Postulantes -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th width="3%">N°</th>
                                <th width="10%">Código</th>
                                <th width="25%">Apellidos y Nombres</th>
                                <th width="10%">DNI</th>
                                <th width="20%">Programa</th>
                                <th width="8%">Turno</th>
                                <th width="8%">Pago</th>
                                <th width="16%">Firma</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $numero = 1;
                            foreach ($postulantes as $postulante): 
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $numero++; ?></td>
                                <td><?php echo $postulante['codigo_inscripcion']; ?></td>
                                <td><?php echo strtoupper($postulante['apellidos'] . ', ' . $postulante['nombres']); ?></td>
                                <td><?php echo $postulante['dni']; ?></td>
                                <td><?php echo $postulante['programa']; ?></td>
                                <td class="text-center"><?php echo ucfirst($postulante['turno']); ?></td>
                                <td class="text-center">
                                    <?php if ($postulante['pago_realizado']): ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <?php else: ?>
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Firmas -->
            <div class="row mt-5">
                <div class="col-md-6 text-center">
                    <div class="mt-5 pt-3" style="border-top: 1px solid #000;">
                        <p class="mb-0"><strong>COORDINADOR DE ADMISIÓN</strong></p>
                        <p class="text-muted">Nombre y Firma</p>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="mt-5 pt-3" style="border-top: 1px solid #000;">
                        <p class="mb-0"><strong>RESPONSABLE DEL AULA</strong></p>
                        <p class="text-muted">Nombre y Firma</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="mt-4">
                <strong>OBSERVACIONES:</strong>
                <div style="border: 1px solid #000; min-height: 100px; padding: 10px; margin-top: 10px;">
                </div>
            </div>

            <div class="text-center mt-4 no-print">
                <small class="text-muted">
                    Documento generado el <?php echo date('d/m/Y H:i'); ?> por <?php echo obtenerNombreUsuario(); ?>
                </small>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>