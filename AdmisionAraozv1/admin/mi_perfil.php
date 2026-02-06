<?php
// admin/mi_perfil.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();
$usuario_id = $_SESSION['admin_id'];

// Obtener datos del usuario
$sql = "SELECT * FROM usuarios_admin WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {
    $sql = "UPDATE usuarios_admin SET nombre_completo = ?, email = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$_POST['nombre_completo'], $_POST['email'], $usuario_id]);
    
    $_SESSION['admin_nombre'] = $_POST['nombre_completo'];
    $success = "Perfil actualizado correctamente";
}

// Cambiar contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_password'])) {
    $password_actual = $_POST['password_actual'];
    $password_nueva = $_POST['password_nueva'];
    $password_confirmar = $_POST['password_confirmar'];
    
    if (password_verify($password_actual, $usuario['password_hash'])) {
        if ($password_nueva === $password_confirmar) {
            $nuevo_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios_admin SET password_hash = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nuevo_hash, $usuario_id]);
            $success = "Contraseña cambiada correctamente";
        } else {
            $error = "Las contraseñas nuevas no coinciden";
        }
    } else {
        $error = "Contraseña actual incorrecta";
    }
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-person-circle"></i> Mi Perfil</h1>
            </div>

            <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-x-circle"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-person-circle" style="font-size: 100px; color: #006b3f;"></i>
                            </div>
                            <h4><?php echo htmlspecialchars($usuario['nombre_completo']); ?></h4>
                            <p class="text-muted"><?php echo ucfirst($usuario['rol']); ?></p>
                            <p><small>Último acceso: <?php echo $usuario['ultimo_acceso'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_acceso'])) : 'Nunca'; ?></small></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <!-- Información Personal -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-fill"></i> Información Personal</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" name="nombre_completo" value="<?php echo htmlspecialchars($usuario['nombre_completo']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Usuario</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['username']); ?>" disabled>
                                </div>
                                <button type="submit" name="actualizar_perfil" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Actualizar Perfil
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-key-fill"></i> Cambiar Contraseña</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" name="password_actual" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" name="password_nueva" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" name="password_confirmar" required>
                                </div>
                                <button type="submit" name="cambiar_password" class="btn btn-warning">
                                    <i class="bi bi-key"></i> Cambiar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>