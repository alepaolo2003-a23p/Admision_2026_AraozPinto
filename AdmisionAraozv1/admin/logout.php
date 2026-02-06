<?php
// admin/logout.php
session_start();

// Registrar en logs antes de cerrar sesión
if (isset($_SESSION['admin_id'])) {
    require_once '../config/database.php';
    
    try {
        $db = conectarDB();
        $sql = "INSERT INTO logs_sistema (usuario_id, accion, descripcion, ip_address) 
                VALUES (?, 'logout', 'Cierre de sesión', ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);
    } catch (Exception $e) {
        // Ignorar errores en el log
    }
}

// Destruir la sesión
session_destroy();

// Redirigir al login
header('Location: login.php');
exit;
?>