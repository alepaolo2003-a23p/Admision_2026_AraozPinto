<?php
// admin/verificar_password.php
// Script para verificar y probar contraseñas

require_once '../config/database.php';

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Verificador de Contraseñas</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .success { background: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; color: #155724; margin: 10px 0; }
        .error { background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; margin: 10px 0; }
        .info { background: #d1ecf1; padding: 15px; border: 1px solid #bee5eb; border-radius: 5px; color: #0c5460; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; background: white; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #006b3f; color: white; }
        .btn { display: inline-block; padding: 10px 20px; background: #006b3f; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
        .btn:hover { background: #004d2e; }
    </style>
</head>
<body>
    <h1>🔐 Verificador de Contraseñas - Panel Admin</h1>
    <hr>";

try {
    $db = conectarDB();
    
    // Obtener todos los usuarios
    $stmt = $db->query("SELECT id, username, password_hash, nombre_completo, email, rol, activo FROM usuarios_admin");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<div class='info'>";
    echo "<h2>📋 Usuarios en la Base de Datos</h2>";
    echo "<p>Total de usuarios: " . count($usuarios) . "</p>";
    echo "</div>";
    
    if (count($usuarios) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Usuario</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Activo</th><th>Hash</th></tr>";
        
        foreach ($usuarios as $user) {
            $activo_badge = $user['activo'] ? '<span style="color: green;">✓ Activo</span>' : '<span style="color: red;">✗ Inactivo</span>';
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td><strong>{$user['username']}</strong></td>";
            echo "<td>{$user['nombre_completo']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "<td>{$user['rol']}</td>";
            echo "<td>{$activo_badge}</td>";
            echo "<td><small>" . substr($user['password_hash'], 0, 30) . "...</small></td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Probar el login
        echo "<hr>";
        echo "<h2>🧪 Prueba de Login</h2>";
        
        $test_username = 'admin';
        $test_password = 'admin123';
        
        $stmt = $db->prepare("SELECT id, username, password_hash, activo FROM usuarios_admin WHERE username = ?");
        $stmt->execute([$test_username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "<div class='info'>";
            echo "<p><strong>Usuario encontrado:</strong> {$user['username']}</p>";
            echo "<p><strong>Estado:</strong> " . ($user['activo'] ? 'Activo' : 'Inactivo') . "</p>";
            echo "</div>";
            
            // Verificar contraseña
            if (password_verify($test_password, $user['password_hash'])) {
                echo "<div class='success'>";
                echo "<h3>✅ ¡Login EXITOSO!</h3>";
                echo "<p><strong>Usuario:</strong> {$test_username}</p>";
                echo "<p><strong>Contraseña:</strong> {$test_password}</p>";
                echo "<p>La contraseña es correcta y puedes usar estas credenciales.</p>";
                echo "</div>";
            } else {
                echo "<div class='error'>";
                echo "<h3>❌ Login FALLIDO</h3>";
                echo "<p>La contraseña '{$test_password}' NO coincide con el hash almacenado.</p>";
                echo "<p><strong>Solución:</strong> Usa el botón de abajo para resetear la contraseña.</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='error'>";
            echo "<h3>❌ Usuario no encontrado</h3>";
            echo "<p>El usuario 'admin' no existe en la base de datos.</p>";
            echo "</div>";
        }
        
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ No hay usuarios en la base de datos</h3>";
        echo "<p>La tabla usuarios_admin está vacía.</p>";
        echo "</div>";
    }
    
    // Botones de acción
    echo "<hr>";
    echo "<h2>🔧 Acciones Disponibles</h2>";
    echo "<div>";
    echo "<a href='reset_password.php' class='btn'>🔄 Resetear Contraseña Admin</a>";
    echo "<a href='login.php' class='btn'>🔐 Ir al Login</a>";
    echo "<a href='../index.php' class='btn'>🏠 Volver al Inicio</a>";
    echo "</div>";
    
    // Información adicional
    echo "<hr>";
    echo "<div class='info'>";
    echo "<h3>ℹ️ Información de Depuración</h3>";
    echo "<p><strong>Contraseña de prueba:</strong> admin123</p>";
    echo "<p><strong>Hash esperado:</strong> \$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi</p>";
    
    // Generar nuevo hash
    $nuevo_hash = password_hash('admin123', PASSWORD_DEFAULT);
    echo "<p><strong>Nuevo hash generado ahora:</strong> {$nuevo_hash}</p>";
    echo "<p><small>Nota: El hash cambia cada vez pero todos son válidos para la misma contraseña.</small></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h2>❌ Error de Conexión</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p><strong>Verifica:</strong></p>";
    echo "<ul>";
    echo "<li>Que MySQL esté corriendo</li>";
    echo "<li>Que las credenciales en config/database.php sean correctas</li>";
    echo "<li>Que la base de datos 'admision_mrap' exista</li>";
    echo "</ul>";
    echo "</div>";
}

echo "</body></html>";
?>