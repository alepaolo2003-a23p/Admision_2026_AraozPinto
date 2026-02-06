<?php
// ========================================
// admin/ver_examen.php
// ========================================

session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$examen_id = $_GET['id'] ?? 0;
$db = conectarDB();

$sql = "SELECT e.*, COUNT(ie.id) as inscritos
        FROM examenes_admision e
        LEFT JOIN inscripciones_examen ie ON e.id = ie.examen_id
        WHERE e.id = ?
        GROUP BY e.id";

$stmt = $db->prepare($sql);
$stmt->execute([$examen_id]);
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$examen) {
    header('Location: examenes.php');
    exit;
}

// Obtener inscritos
$sql = "SELECT p.*, ie.codigo_inscripcion, ie.pago_realizado, prog.nombre as programa
        FROM inscripciones_examen ie
        INNER JOIN postulantes p ON ie.postulante_id = p.id
        LEFT JOIN opciones_carrera oc ON p.id = oc.postulante_id AND oc.orden_preferencia = 'primera'
        LEFT JOIN programas_estudio prog ON oc.programa_id = prog.id
        WHERE ie.examen_id = ?
        ORDER BY p.apellidos, p.nombres";

$stmt = $db->prepare($sql);
$stmt->execute([$examen_id]);
$inscritos = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-clipboard-check-fill"></i> Detalle del Examen</h1>
                <div class="btn-toolbar">
                    <a href="examenes.php" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <a href="lista_asistencia.php?id=<?php echo $examen_id; ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-list-check"></i> Lista de Asistencia
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Información del Examen</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Código:</strong><br><?php echo $examen['codigo_examen']; ?></p>
                            <p><strong>Fecha:</strong><br><?php echo date('d/m/Y', strtotime($examen['fecha_examen'])); ?></p>
                            <p><strong>Hora:</strong><br><?php echo date('H:i', strtotime($examen['hora_inicio'])); ?></p>
                            <p><strong>Duración:</strong><br><?php echo $examen['duracion_minutos']; ?> minutos</p>
                            <p><strong>Aula:</strong><br><?php echo $examen['aula'] ?: 'No asignada'; ?></p>
                            <p><strong>Capacidad:</strong><br><?php echo $examen['inscritos']; ?> / <?php echo $examen['capacidad_maxima']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Postulantes Inscritos (<?php echo count($inscritos); ?>)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Postulante</th>
                                            <th>DNI</th>
                                            <th>Programa</th>
                                            <th>Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($inscritos as $inscrito): ?>
                                        <tr>
                                            <td><?php echo $inscrito['codigo_inscripcion']; ?></td>
                                            <td><?php echo $inscrito['nombres'] . ' ' . $inscrito['apellidos']; ?></td>
                                            <td><?php echo $inscrito['dni']; ?></td>
                                            <td><?php echo $inscrito['programa']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $inscrito['pago_realizado'] ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                                    <?php echo $inscrito['pago_realizado'] ? 'Pagado' : 'Pendiente'; ?>
                                                </span>
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

<?php include 'includes/footer.php'; ?>