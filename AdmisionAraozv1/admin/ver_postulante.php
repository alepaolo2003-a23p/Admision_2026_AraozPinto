<?php
// admin/ver_postulante.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$postulante_id = $_GET['id'] ?? 0;

if (!$postulante_id) {
    header('Location: postulantes.php');
    exit;
}

$db = conectarDB();

// Obtener datos completos del postulante
$sql = "SELECT p.*, ia.*, 
        prog1.nombre as programa_primera, oc1.turno as turno_primera,
        prog2.nombre as programa_segunda, oc2.turno as turno_segunda,
        ap.nombre_completo as nombre_apoderado, ap.dni_apoderado, ap.parentesco, 
        ap.telefono as telefono_apoderado, ap.email as email_apoderado,
        ie.codigo_inscripcion, ie.pago_realizado, ie.monto_pagado, ie.fecha_pago,
        e.fecha_examen, e.hora_inicio, e.aula
        FROM postulantes p
        LEFT JOIN informacion_academica ia ON p.id = ia.postulante_id
        LEFT JOIN opciones_carrera oc1 ON p.id = oc1.postulante_id AND oc1.orden_preferencia = 'primera'
        LEFT JOIN programas_estudio prog1 ON oc1.programa_id = prog1.id
        LEFT JOIN opciones_carrera oc2 ON p.id = oc2.postulante_id AND oc2.orden_preferencia = 'segunda'
        LEFT JOIN programas_estudio prog2 ON oc2.programa_id = prog2.id
        LEFT JOIN apoderados ap ON p.id = ap.postulante_id
        LEFT JOIN inscripciones_examen ie ON p.id = ie.postulante_id
        LEFT JOIN examenes_admision e ON ie.examen_id = e.id
        WHERE p.id = ?";

$stmt = $db->prepare($sql);
$stmt->execute([$postulante_id]);
$postulante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$postulante) {
    header('Location: postulantes.php');
    exit;
}

// Obtener documentos
$sql = "SELECT * FROM documentos WHERE postulante_id = ? ORDER BY tipo_documento";
$stmt = $db->prepare($sql);
$stmt->execute([$postulante_id]);
$documentos = $stmt->fetchAll();

// Obtener declaraciones juradas
$sql = "SELECT * FROM declaraciones_juradas WHERE postulante_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$postulante_id]);
$declaraciones = $stmt->fetchAll();

// Actualizar estado si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_estado'])) {
    $nuevo_estado = $_POST['estado_inscripcion'];
    $sql = "UPDATE postulantes SET estado_inscripcion = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nuevo_estado, $postulante_id]);
    
    header('Location: ver_postulante.php?id=' . $postulante_id . '&success=1');
    exit;
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-person-circle"></i> Detalle del Postulante</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="postulantes.php" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Estado actualizado correctamente
            </div>
            <?php endif; ?>

            <!-- Información General -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-fill"></i> Información Personal</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nombres:</strong><br>
                                    <?php echo htmlspecialchars($postulante['nombres']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Apellidos:</strong><br>
                                    <?php echo htmlspecialchars($postulante['apellidos']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>DNI:</strong><br>
                                    <?php echo htmlspecialchars($postulante['dni']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Fecha de Nacimiento:</strong><br>
                                    <?php echo date('d/m/Y', strtotime($postulante['fecha_nacimiento'])); ?>
                                    <span class="badge <?php echo $postulante['es_menor_edad'] ? 'bg-warning text-dark' : 'bg-success'; ?>">
                                        <?php echo $postulante['edad']; ?> años (<?php echo $postulante['es_menor_edad'] ? 'Menor' : 'Mayor'; ?> de edad)
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Email:</strong><br>
                                    <?php echo htmlspecialchars($postulante['email']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Teléfono:</strong><br>
                                    <?php echo htmlspecialchars($postulante['telefono'] ?: 'No registrado'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <strong>Dirección:</strong><br>
                                    <?php echo htmlspecialchars($postulante['direccion'] ?: 'No registrada'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Académica -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-mortarboard-fill"></i> Información Académica</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Colegio de Procedencia:</strong><br>
                                    <?php echo htmlspecialchars($postulante['colegio_procedencia']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Grado Actual:</strong><br>
                                    <?php 
                                    $grados = [
                                        'tercero' => '3° de Secundaria',
                                        'cuarto' => '4° de Secundaria',
                                        'quinto' => '5° de Secundaria',
                                        'egresado' => 'Egresado'
                                    ];
                                    echo $grados[$postulante['grado_actual']] ?? 'No especificado'; 
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Promedio Último Año:</strong><br>
                                    <?php echo $postulante['promedio_ultimo'] ?: 'No registrado'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Programas Seleccionados -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-book-fill"></i> Programas Seleccionados</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Primera Opción:</strong><br>
                                    <?php echo htmlspecialchars($postulante['programa_primera']); ?><br>
                                    <span class="badge bg-primary">Turno: <?php echo ucfirst($postulante['turno_primera']); ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Segunda Opción:</strong><br>
                                    <?php echo htmlspecialchars($postulante['programa_segunda']); ?><br>
                                    <span class="badge bg-secondary">Turno: <?php echo ucfirst($postulante['turno_segunda']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Apoderado -->
                    <?php if ($postulante['nombre_apoderado']): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-badge-fill"></i> Información del Apoderado</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Nombre Completo:</strong><br>
                                    <?php echo htmlspecialchars($postulante['nombre_apoderado']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>DNI:</strong><br>
                                    <?php echo htmlspecialchars($postulante['dni_apoderado']); ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Parentesco:</strong><br>
                                    <?php echo ucfirst($postulante['parentesco']); ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Teléfono:</strong><br>
                                    <?php echo htmlspecialchars($postulante['telefono_apoderado'] ?: 'No registrado'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Documentos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-text-fill"></i> Documentos</h5>
                        </div>
                        <div class="card-body">
                            <?php if (count($documentos) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Archivo</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($documentos as $doc): ?>
                                        <tr>
                                            <td><?php echo ucfirst(str_replace('_', ' ', $doc['tipo_documento'])); ?></td>
                                            <td><?php echo htmlspecialchars($doc['nombre_archivo']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($doc['fecha_subida'])); ?></td>
                                            <td>
                                                <?php
                                                $badge_class = '';
                                                switch($doc['estado_verificacion']) {
                                                    case 'pendiente': $badge_class = 'bg-warning text-dark'; break;
                                                    case 'aprobado': $badge_class = 'bg-success'; break;
                                                    case 'rechazado': $badge_class = 'bg-danger'; break;
                                                }
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo ucfirst($doc['estado_verificacion']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="../<?php echo $doc['ruta_archivo']; ?>" class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <p class="text-muted">No hay documentos cargados</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar derecha -->
                <div class="col-md-4">
                    <!-- Estado de Inscripción -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-info-circle-fill"></i> Estado</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Estado de Inscripción</label>
                                    <select class="form-select" name="estado_inscripcion">
                                        <option value="pendiente" <?php echo $postulante['estado_inscripcion'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="completado" <?php echo $postulante['estado_inscripcion'] == 'completado' ? 'selected' : ''; ?>>Completado</option>
                                        <option value="rechazado" <?php echo $postulante['estado_inscripcion'] == 'rechazado' ? 'selected' : ''; ?>>Rechazado</option>
                                    </select>
                                </div>
                                <button type="submit" name="actualizar_estado" class="btn btn-primary w-100">
                                    <i class="bi bi-save"></i> Actualizar Estado
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Información de Inscripción -->
                    <?php if ($postulante['codigo_inscripcion']): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-clipboard-check-fill"></i> Inscripción</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Código:</strong><br><?php echo $postulante['codigo_inscripcion']; ?></p>
                            <p><strong>Monto:</strong><br>S/. <?php echo number_format($postulante['monto_pagado'], 2); ?></p>
                            <p>
                                <strong>Estado de Pago:</strong><br>
                                <?php if ($postulante['pago_realizado']): ?>
                                <span class="badge bg-success">Pagado</span><br>
                                <small>Fecha: <?php echo date('d/m/Y', strtotime($postulante['fecha_pago'])); ?></small>
                                <?php else: ?>
                                <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Información del Examen -->
                    <?php if ($postulante['fecha_examen']): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-calendar-event-fill"></i> Examen</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha:</strong><br><?php echo date('d/m/Y', strtotime($postulante['fecha_examen'])); ?></p>
                            <p><strong>Hora:</strong><br><?php echo date('H:i', strtotime($postulante['hora_inicio'])); ?></p>
                            <?php if ($postulante['aula']): ?>
                            <p><strong>Aula:</strong><br><?php echo $postulante['aula']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Registro -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-clock-history"></i> Registro</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><small>Registrado el:<br><?php echo date('d/m/Y H:i', strtotime($postulante['fecha_registro'])); ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>