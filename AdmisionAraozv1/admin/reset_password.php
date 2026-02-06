<?php
// admin/reset_password.php
// IMPORTANTE: Elimina este archivo después de usarlo por seguridad

require_once '../config/database.php';

echo "<h1>Reset de Contraseña - Panel Administrativo</h1>";
echo "<hr>";

try {
    $db = conectarDB();
    
    // Nuevas credenciales
    $username = 'admin';
    $nueva_password = 'admin123';
    $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
    
    // Verificar si el usuario existe
    $stmt = $db->prepare("SELECT id FROM usuarios_admin WHERE username = ?");
    $stmt->execute([$username]);
    $usuario = $stmt->fetch();
    
    if ($usuario) {
        // Actualizar contraseña existente
        $sql = "UPDATE usuarios_admin SET password_hash = ?, activo = 1 WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$password_hash, $username]);
        
        echo "<div style='background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; border-radius: 5px;'>";
        echo "<h2 style='color: #155724;'>✅ Contraseña actualizada correctamente</h2>";
        echo "<p><strong>Usuario:</strong> admin</p>";
        echo "<p><strong>Contraseña:</strong> admin123</p>";
        echo "<p><strong>Hash generado:</strong> " . $password_hash . "</p>";
        echo "</div>";
    } else {
        // Crear nuevo usuario admin
        $sql = "INSERT INTO usuarios_admin (username, password_hash, nombre_completo, email, rol, activo) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $username,
            $password_hash,
            'Administrador del Sistema',
            'admin@institutoaraozpinto.com',
            'admin',
            1
        ]);
        
        echo "<div style='background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; border-radius: 5px;'>";
        echo "<h2 style='color: #155724;'>✅ Usuario administrador creado correctamente</h2>";
        echo "<p><strong>Usuario:</strong> admin</p>";
        echo "<p><strong>Contraseña:</strong> admin123</p>";
        echo "<p><strong>Hash generado:</strong> " . $password_hash . "</p>";
        echo "</div>";
    }
    
    echo "<hr>";
    echo "<h3>Accesos disponibles:</h3>";
    echo "<ul>";
    echo "<li><a href='login.php' style='color: #007bff; font-size: 18px;'>👉 Ir al Login del Panel Administrativo</a></li>";
    echo "<li><a href='../index.php' style='color: #007bff; font-size: 18px;'>👉 Volver a la página principal</a></li>";
    echo "</ul>";
    
    echo "<hr>";
    echo "<div style='background: #fff3cd; padding: 15px; border: 1px solid #ffc107; border-radius: 5px; margin-top: 20px;'>";
    echo "<p style='color: #856404; margin: 0;'><strong>⚠️ IMPORTANTE:</strong> Por seguridad, elimina este archivo después de usarlo:</p>";
    echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 5px;'>rm admin/reset_password.php</pre>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 20px; border: 1px solid #f5c6cb; border-radius: 5px;'>";
    echo "<h2 style='color: #721c24;'>❌ Error</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MRAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
    </style>
</head>
<body>
</body>
</html>