<?php
// admin/eliminar_postulante.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();
verificarRol(['admin', 'coordinador']); // Solo admin y coordinador pueden eliminar

$postulante_id = $_GET['id'] ?? 0;

if (!$postulante_id) {
    header('Location: postulantes.php?error=id_invalido');
    exit;
}

$db = conectarDB();

try {
    // Obtener nombre del postulante para el log
    $stmt = $db->prepare("SELECT nombres, apellidos, dni FROM postulantes WHERE id = ?");
    $stmt->execute([$postulante_id]);
    $postulante = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$postulante) {
        throw new Exception("Postulante no encontrado");
    }
    
    $db->beginTransaction();
    
    // Eliminar archivos físicos
    $stmt = $db->prepare("SELECT ruta_archivo FROM documentos WHERE postulante_id = ?");
    $stmt->execute([$postulante_id]);
    $documentos = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($documentos as $ruta) {
        if (file_exists('../' . $ruta)) {
            unlink('../' . $ruta);
        }
    }
    
    // Eliminar postulante (CASCADE eliminará registros relacionados)
    $stmt = $db->prepare("DELETE FROM postulantes WHERE id = ?");
    $stmt->execute([$postulante_id]);
    
    // Registrar en logs
    $sql = "INSERT INTO logs_sistema (usuario_id, accion, descripcion, ip_address) 
            VALUES (?, 'eliminar_postulante', ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_SESSION['admin_id'],
        "Eliminó postulante: {$postulante['nombres']} {$postulante['apellidos']} (DNI: {$postulante['dni']})",
        $_SERVER['REMOTE_ADDR']
    ]);
    
    $db->commit();
    
    header('Location: postulantes.php?success=eliminado');
    exit;
    
} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    header('Location: postulantes.php?error=' . urlencode($e->getMessage()));
    exit;
}
?>