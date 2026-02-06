<?php
// admin/usuarios.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();
verificarRol(['admin']); // Solo administradores

$db = conectarDB();

// Crear nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_usuario'])) {
    try {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios_admin (username, password_hash, nombre_completo, email, rol, activo) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $_POST['username'],
            $password_hash,
            $_POST['nombre_completo'],
            $_POST['email'],
            $_POST['rol'],
            1
        ]);
        
        $success = "Usuario creado correctamente";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Cambiar estado de usuario
if (isset($_GET['toggle_estado'])) {
    $id = $_GET['toggle_estado'];
    $sql = "UPDATE usuarios_admin SET activo = NOT activo WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    header('Location: usuarios.php?success=estado_actualizado');
    exit;
}

// Obtener todos los usuarios
$usuarios = $db->query("SELECT * FROM usuarios_admin ORDER BY fecha_creacion DESC")->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-person-badge-fill"></i> Gestión de Usuarios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                        <i class="bi bi-plus-circle"></i> Nuevo Usuario
                    </button>
                </div>
            </div>

            <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?php echo $success; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-x-circle"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Operación realizada correctamente
            </div>
            <?php endif; ?>

            <!-- Lista de Usuarios -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Usuarios del Sistema (<?php echo count($usuarios); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Último Acceso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($user['nombre_completo']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($user['rol']) {
                                            case 'admin': $badge_class = 'bg-danger'; break;
                                            case 'coordinador': $badge_class = 'bg-warning text-dark'; break;
                                            case 'evaluador': $badge_class = 'bg-info'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($user['rol']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user['activo']): ?>
                                        <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if ($user['ultimo_acceso']) {
                                            echo date('d/m/Y H:i', strtotime($user['ultimo_acceso']));
                                        } else {
                                            echo '<span class="text-muted">Nunca</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary" onclick="editarUsuario(<?php echo $user['id']; ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            
                                            <?php if ($user['id'] != $_SESSION['admin_id']): ?>
                                            <a href="usuarios.php?toggle_estado=<?php echo $user['id']; ?>" 
                                               class="btn btn-warning"
                                               onclick="return confirm('¿Cambiar estado del usuario?')">
                                                <i class="bi bi-<?php echo $user['activo'] ? 'lock' : 'unlock'; ?>"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-danger" onclick="eliminarUsuario(<?php echo $user['id']; ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <?php else: ?>
                                            <button type="button" class="btn btn-secondary" disabled title="No puedes modificar tu propio usuario">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                            <?php endif; ?>
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

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="nuevoUsuarioModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus-fill"></i> Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre_completo" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                        <small class="text-muted">Mínimo 8 caracteres</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select class="form-select" name="rol" required>
                            <option value="">Seleccione...</option>
                            <option value="admin">Administrador</option>
                            <option value="coordinador">Coordinador</option>
                            <option value="evaluador">Evaluador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="crear_usuario" class="btn btn-primary">
                        <i class="bi bi-save"></i> Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editarUsuario(id) {
    alert('Función de edición en desarrollo. ID: ' + id);
}

function eliminarUsuario(id) {
    if (confirm('¿Está seguro de eliminar este usuario? Esta acción no se puede deshacer.')) {
        window.location.href = 'eliminar_usuario.php?id=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>