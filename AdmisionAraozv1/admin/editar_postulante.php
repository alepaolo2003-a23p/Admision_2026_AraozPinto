<?php
// admin/editar_postulante.php
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

// Obtener datos del postulante
$sql = "SELECT p.*, ia.colegio_procedencia, ia.grado_actual, ia.promedio_ultimo,
        oc1.programa_id as programa_primera_id, oc1.turno as turno_primera,
        oc2.programa_id as programa_segunda_id, oc2.turno as turno_segunda,
        ap.nombre_completo as nombre_apoderado, ap.dni_apoderado, ap.parentesco, ap.telefono as telefono_apoderado
        FROM postulantes p
        LEFT JOIN informacion_academica ia ON p.id = ia.postulante_id
        LEFT JOIN opciones_carrera oc1 ON p.id = oc1.postulante_id AND oc1.orden_preferencia = 'primera'
        LEFT JOIN opciones_carrera oc2 ON p.id = oc2.postulante_id AND oc2.orden_preferencia = 'segunda'
        LEFT JOIN apoderados ap ON p.id = ap.postulante_id
        WHERE p.id = ?";

$stmt = $db->prepare($sql);
$stmt->execute([$postulante_id]);
$postulante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$postulante) {
    header('Location: postulantes.php');
    exit;
}

// Obtener programas
$programas = $db->query("SELECT id, nombre FROM programas_estudio ORDER BY nombre")->fetchAll();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();
        
        // Actualizar postulante
        $sql = "UPDATE postulantes SET nombres = ?, apellidos = ?, email = ?, telefono = ?, direccion = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['email'],
            $_POST['telefono'],
            $_POST['direccion'],
            $postulante_id
        ]);
        
        // Actualizar información académica
        $sql = "UPDATE informacion_academica SET colegio_procedencia = ?, grado_actual = ?, promedio_ultimo = ? WHERE postulante_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $_POST['colegio_procedencia'],
            $_POST['grado_actual'],
            $_POST['promedio_ultimo'],
            $postulante_id
        ]);
        
        // Actualizar apoderado
        $sql = "UPDATE apoderados SET nombre_completo = ?, dni_apoderado = ?, parentesco = ?, telefono = ? WHERE postulante_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $_POST['nombre_apoderado'],
            $_POST['dni_apoderado'],
            $_POST['parentesco'],
            $_POST['telefono_apoderado'],
            $postulante_id
        ]);
        
        $db->commit();
        header('Location: ver_postulante.php?id=' . $postulante_id . '&success=1');
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        $error = $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-pencil-square"></i> Editar Postulante</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="ver_postulante.php?id=<?php echo $postulante_id; ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-x-circle"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form method="POST">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Información Personal -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-person-fill"></i> Información Personal</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nombres</label>
                                        <input type="text" class="form-control" name="nombres" value="<?php echo htmlspecialchars($postulante['nombres']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" name="apellidos" value="<?php echo htmlspecialchars($postulante['apellidos']); ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($postulante['email']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" name="telefono" value="<?php echo htmlspecialchars($postulante['telefono']); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <textarea class="form-control" name="direccion" rows="2"><?php echo htmlspecialchars($postulante['direccion']); ?></textarea>
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
                                        <label class="form-label">Colegio de Procedencia</label>
                                        <input type="text" class="form-control" name="colegio_procedencia" value="<?php echo htmlspecialchars($postulante['colegio_procedencia']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nivel Educativo</label>
                                        <select class="form-select" name="grado_actual" required>
                                            <option value="secundaria_incompleta" <?php echo $postulante['grado_actual'] == 'secundaria_incompleta' ? 'selected' : ''; ?>>Secundaria Incompleta</option>
                                            <option value="secundaria_completa" <?php echo $postulante['grado_actual'] == 'secundaria_completa' ? 'selected' : ''; ?>>Secundaria Completa</option>
                                            <option value="tecnica_curso" <?php echo $postulante['grado_actual'] == 'tecnica_curso' ? 'selected' : ''; ?>>Técnica en Curso</option>
                                            <option value="tecnica_completa" <?php echo $postulante['grado_actual'] == 'tecnica_completa' ? 'selected' : ''; ?>>Técnica Completa</option>
                                            <option value="universitaria_curso" <?php echo $postulante['grado_actual'] == 'universitaria_curso' ? 'selected' : ''; ?>>Universitaria en Curso</option>
                                            <option value="universitaria_completa" <?php echo $postulante['grado_actual'] == 'universitaria_completa' ? 'selected' : ''; ?>>Universitaria Completa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Promedio</label>
                                        <input type="number" class="form-control" name="promedio_ultimo" value="<?php echo $postulante['promedio_ultimo']; ?>" min="0" max="20" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Apoderado -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-person-badge-fill"></i> Información del Apoderado</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control" name="nombre_apoderado" value="<?php echo htmlspecialchars($postulante['nombre_apoderado']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">DNI del Apoderado</label>
                                        <input type="text" class="form-control" name="dni_apoderado" value="<?php echo htmlspecialchars($postulante['dni_apoderado']); ?>" maxlength="8" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Parentesco</label>
                                        <select class="form-select" name="parentesco" required>
                                            <option value="padre" <?php echo $postulante['parentesco'] == 'padre' ? 'selected' : ''; ?>>Padre</option>
                                            <option value="madre" <?php echo $postulante['parentesco'] == 'madre' ? 'selected' : ''; ?>>Madre</option>
                                            <option value="tutor" <?php echo $postulante['parentesco'] == 'tutor' ? 'selected' : ''; ?>>Tutor</option>
                                            <option value="otro" <?php echo $postulante['parentesco'] == 'otro' ? 'selected' : ''; ?>>Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" name="telefono_apoderado" value="<?php echo htmlspecialchars($postulante['telefono_apoderado']); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Datos No Editables -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-lock-fill"></i> Datos No Editables</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>DNI:</strong><br><?php echo $postulante['dni']; ?></p>
                                <p><strong>Fecha de Nacimiento:</strong><br><?php echo date('d/m/Y', strtotime($postulante['fecha_nacimiento'])); ?></p>
                                <p><strong>Edad:</strong><br><?php echo $postulante['edad']; ?> años</p>
                                <p class="mb-0"><strong>Fecha de Registro:</strong><br><?php echo date('d/m/Y H:i', strtotime($postulante['fecha_registro'])); ?></p>
                            </div>
                        </div>

                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                        
                        <a href="ver_postulante.php?id=<?php echo $postulante_id; ?>" class="btn btn-secondary w-100">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>