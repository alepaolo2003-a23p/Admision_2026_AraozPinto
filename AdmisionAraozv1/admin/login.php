<?php
// admin/login.php
session_start();
require_once '../config/database.php';

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $db = conectarDB();
        $sql = "SELECT id, username, password_hash, nombre_completo, rol, activo 
                FROM usuarios_admin 
                WHERE username = ? AND activo = 1";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            // Login exitoso
            $_SESSION['admin_id'] = $usuario['id'];
            $_SESSION['admin_username'] = $usuario['username'];
            $_SESSION['admin_nombre'] = $usuario['nombre_completo'];
            $_SESSION['admin_rol'] = $usuario['rol'];
            
            // Actualizar último acceso
            $sql = "UPDATE usuarios_admin SET ultimo_acceso = NOW() WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$usuario['id']]);
            
            // Registrar en logs
            $sql = "INSERT INTO logs_sistema (usuario_id, accion, descripcion, ip_address) 
                    VALUES (?, 'login', 'Inicio de sesión exitoso', ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$usuario['id'], $_SERVER['REMOTE_ADDR']]);
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
    } catch (Exception $e) {
        $error = 'Error al procesar el login';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panel Administrativo MRAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #006b3f;
            --dark-green: #004d2e;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        
        .login-header {
            background: var(--primary-green);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .login-header h3 {
            margin: 0;
            font-weight: bold;
        }
        
        .login-body {
            padding: 40px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 2px solid #e0e0e0;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(0, 107, 63, 0.25);
        }
        
        .btn-login {
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-login:hover {
            background: var(--dark-green);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3><i class="bi bi-shield-lock-fill"></i> Panel Administrativo</h3>
            <p class="mb-0">IESTP María Rosario Araoz Pinto</p>
        </div>
        
        <div class="login-body">
            <?php if ($error): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="username" required autofocus>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </button>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    Usuario por defecto: admin / admin123
                </small>
            </div>
        </div>
    </div>
</body>
</html>