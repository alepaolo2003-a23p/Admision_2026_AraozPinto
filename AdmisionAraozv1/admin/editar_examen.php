<?php

// ========================================
// admin/editar_examen.php
// ========================================

session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$examen_id = $_GET['id'] ?? 0;
$db = conectarDB();

$stmt = $db->prepare("SELECT * FROM examenes_admision WHERE id = ?");
$stmt->execute([$examen_id]);
$examen = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$examen) {
    header('Location: examenes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE examenes_admision 
            SET fecha_examen = ?, hora_inicio = ?, duracion_minutos = ?, 
                aula = ?, capacidad_maxima = ?, estado = ?
            WHERE id = ?";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['fecha_examen'],
        $_POST['hora_inicio'],
        $_POST['duracion_minutos'],
        $_POST['aula'],
        $_POST['capacidad_maxima'],
        $_POST['estado'],
        $examen_id
    ]);
    
    header('Location: ver_examen.php?id=' . $examen_id . '&success=1');
    exit;
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h1 class="h2 pt-3"><i class="bi bi-pencil-square"></i> Editar Examen</h1>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha del Examen</label>
                                <input type="date" class="form-control" name="fecha_examen" value="<?php echo $examen['fecha_examen']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control" name="hora_inicio" value="<?php echo $examen['hora_inicio']; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Duración (minutos)</label>
                                <input type="number" class="form-control" name="duracion_minutos" value="<?php echo $examen['duracion_minutos']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Aula</label>
                                <input type="text" class="form-control" name="aula" value="<?php echo $examen['aula']; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Capacidad</label>
                                <input type="number" class="form-control" name="capacidad_maxima" value="<?php echo $examen['capacidad_maxima']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado" required>
                                <option value="programado" <?php echo $examen['estado'] == 'programado' ? 'selected' : ''; ?>>Programado</option>
                                <option value="en_curso" <?php echo $examen['estado'] == 'en_curso' ? 'selected' : ''; ?>>En Curso</option>
                                <option value="finalizado" <?php echo $examen['estado'] == 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                                <option value="cancelado" <?php echo $examen['estado'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="ver_examen.php?id=<?php echo $examen_id; ?>" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
*/
?>
