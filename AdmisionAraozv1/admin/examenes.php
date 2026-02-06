<?php
// admin/examenes.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();

// Obtener todos los exámenes con cantidad de inscritos
$sql = "SELECT e.*, 
        COUNT(ie.id) as inscritos,
        SUM(CASE WHEN ie.pago_realizado = 1 THEN 1 ELSE 0 END) as pagados
        FROM examenes_admision e
        LEFT JOIN inscripciones_examen ie ON e.id = ie.examen_id
        GROUP BY e.id
        ORDER BY e.fecha_examen DESC";

$examenes = $db->query($sql)->fetchAll();

// Crear nuevo examen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_examen'])) {
    $codigo = $_POST['codigo_examen'];
    $fecha = $_POST['fecha_examen'];
    $hora = $_POST['hora_inicio'];
    $duracion = $_POST['duracion_minutos'];
    $aula = $_POST['aula'];
    $capacidad = $_POST['capacidad_maxima'];
    
    try {
        $sql = "INSERT INTO examenes_admision (codigo_examen, fecha_examen, hora_inicio, duracion_minutos, aula, capacidad_maxima, estado) 
                VALUES (?, ?, ?, ?, ?, ?, 'programado')";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$codigo, $fecha, $hora, $duracion, $aula, $capacidad]);
        
        header('Location: examenes.php?success=1');
        exit;
    } catch (Exception $e) {
        $error = 'Error al crear el examen: ' . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-clipboard-check-fill"></i> Gestión de Exámenes</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoExamenModal">
                        <i class="bi bi-plus-circle"></i> Nuevo Examen
                    </button>
                </div>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Operación realizada correctamente
            </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-x-circle"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <!-- Lista de exámenes -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Exámenes de Admisión</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Duración</th>
                                    <th>Aula</th>
                                    <th>Capacidad</th>
                                    <th>Inscritos</th>
                                    <th>Pagados</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($examenes as $examen): ?>
                                <tr>
                                    <td><strong><?php echo $examen['codigo_examen']; ?></strong></td>
                                    <td><?php echo date('d/m/Y', strtotime($examen['fecha_examen'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($examen['hora_inicio'])); ?></td>
                                    <td><?php echo $examen['duracion_minutos']; ?> min</td>
                                    <td><?php echo $examen['aula'] ?: '-'; ?></td>
                                    <td>
                                        <?php echo $examen['inscritos']; ?> / <?php echo $examen['capacidad_maxima']; ?>
                                        <?php if ($examen['inscritos'] >= $examen['capacidad_maxima']): ?>
                                        <span class="badge bg-warning text-dark">Lleno</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $examen['inscritos']; ?></td>
                                    <td><?php echo $examen['pagados']; ?></td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($examen['estado']) {
                                            case 'programado': $badge_class = 'bg-info'; break;
                                            case 'en_curso': $badge_class = 'bg-warning'; break;
                                            case 'finalizado': $badge_class = 'bg-success'; break;
                                            case 'cancelado': $badge_class = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($examen['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="ver_examen.php?id=<?php echo $examen['id']; ?>" class="btn btn-primary" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="editar_examen.php?id=<?php echo $examen['id']; ?>" class="btn btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="lista_asistencia.php?id=<?php echo $examen['id']; ?>" class="btn btn-info" title="Lista de asistencia">
                                                <i class="bi bi-list-check"></i>
                                            </a>
                                        </div>
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

<!-- Modal Nuevo Examen -->
<div class="modal fade" id="nuevoExamenModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Crear Nuevo Examen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Código del Examen</label>
                            <input type="text" class="form-control" name="codigo_examen" value="EX-2026-<?php echo rand(100, 999); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha del Examen</label>
                            <input type="date" class="form-control" name="fecha_examen" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" name="hora_inicio" value="09:00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Duración (minutos)</label>
                            <input type="number" class="form-control" name="duracion_minutos" value="120" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Aula</label>
                            <input type="text" class="form-control" name="aula" placeholder="Ej: A-101">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Capacidad Máxima</label>
                            <input type="number" class="form-control" name="capacidad_maxima" value="30" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="crear_examen" class="btn btn-primary">
                        <i class="bi bi-save"></i> Crear Examen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>