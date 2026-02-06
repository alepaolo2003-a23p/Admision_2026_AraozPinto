<?php
// admin/configuracion.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();
verificarRol(['admin']); // Solo administradores

$db = conectarDB();

// Procesar actualización de configuración
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Aquí puedes agregar lógica para guardar configuraciones
        // Por ejemplo, en una tabla de configuración
        
        $success = "Configuración actualizada correctamente";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener estadísticas del sistema
$stats = [];
$stats['total_postulantes'] = $db->query("SELECT COUNT(*) FROM postulantes")->fetchColumn();
$stats['total_usuarios'] = $db->query("SELECT COUNT(*) FROM usuarios_admin")->fetchColumn();
$stats['total_examenes'] = $db->query("SELECT COUNT(*) FROM examenes_admision")->fetchColumn();
$stats['espacio_uploads'] = 0;

// Calcular espacio usado
if (is_dir('../uploads')) {
    $stats['espacio_uploads'] = round(dirSize('../uploads') / 1024 / 1024, 2); // MB
}

function dirSize($directory) {
    $size = 0;
    if (!is_dir($directory)) return $size;
    
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file) {
        if ($file->isFile()) {
            $size += $file->getSize();
        }
    }
    return $size;
}

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-gear-fill"></i> Configuración del Sistema</h1>
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

            <div class="row">
                <!-- Información del Sistema -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-info-circle-fill"></i> Información del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Versión del Sistema:</strong></td>
                                    <td>1.0.0</td>
                                </tr>
                                <tr>
                                    <td><strong>Versión PHP:</strong></td>
                                    <td><?php echo phpversion(); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Base de Datos:</strong></td>
                                    <td>MySQL <?php echo $db->query("SELECT VERSION()")->fetchColumn(); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Postulantes:</strong></td>
                                    <td><?php echo $stats['total_postulantes']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Usuarios Admin:</strong></td>
                                    <td><?php echo $stats['total_usuarios']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Exámenes:</strong></td>
                                    <td><?php echo $stats['total_examenes']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Espacio en Uploads:</strong></td>
                                    <td><?php echo $stats['espacio_uploads']; ?> MB</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Base de Datos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-database-fill"></i> Base de Datos</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" onclick="hacerBackup()">
                                    <i class="bi bi-download"></i> Hacer Backup de BD
                                </button>
                                <button type="button" class="btn btn-warning" onclick="limpiarLogs()">
                                    <i class="bi bi-trash"></i> Limpiar Logs Antiguos
                                </button>
                                <a href="optimizar_bd.php" class="btn btn-info">
                                    <i class="bi bi-lightning-charge"></i> Optimizar Tablas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuración General -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-sliders"></i> Configuración General</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Nombre del Instituto</label>
                                    <input type="text" class="form-control" name="nombre_instituto" value="IESTP María Rosario Araoz Pinto" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email de Contacto</label>
                                    <input type="email" class="form-control" name="email_contacto" value="contacto@institutoaraozpinto.com" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" name="telefono" value="+51 999 999 999">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <textarea class="form-control" name="direccion" rows="2">Calle José Martí 155, San Miguel, Lima</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Costo de Inscripción (S/.)</label>
                                    <input type="number" class="form-control" name="costo_inscripcion" value="150.00" step="0.01" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar Configuración
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Configuración de Email -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-envelope-fill"></i> Configuración de Email</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Servidor SMTP</label>
                                    <input type="text" class="form-control" name="smtp_host" placeholder="smtp.gmail.com">
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Puerto</label>
                                        <input type="number" class="form-control" name="smtp_port" value="587">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Encriptación</label>
                                        <select class="form-select" name="smtp_encryption">
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Usuario SMTP</label>
                                    <input type="text" class="form-control" name="smtp_username">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Contraseña SMTP</label>
                                    <input type="password" class="form-control" name="smtp_password">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar Configuración Email
                                </button>
                                
                                <button type="button" class="btn btn-secondary" onclick="probarEmail()">
                                    <i class="bi bi-send"></i> Probar Envío
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mantenimiento -->
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Zona de Peligro</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-danger"><strong>¡Precaución!</strong> Las siguientes acciones son irreversibles.</p>
                            
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarLimpiezaTotal()">
                                    <i class="bi bi-trash"></i> Limpiar Todos los Datos de Prueba
                                </button>
                                
                                <button type="button" class="btn btn-outline-danger" onclick="confirmarResetSistema()">
                                    <i class="bi bi-arrow-clockwise"></i> Resetear Sistema
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function hacerBackup() {
    if (confirm('¿Desea hacer un backup de la base de datos?')) {
        window.location.href = 'backup_bd.php';
    }
}

function limpiarLogs() {
    if (confirm('¿Desea eliminar logs antiguos (más de 6 meses)?')) {
        fetch('limpiar_logs.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Logs limpiados correctamente');
                    location.reload();
                }
            });
    }
}

function probarEmail() {
    alert('Función de prueba de email en desarrollo');
}

function confirmarLimpiezaTotal() {
    if (confirm('ADVERTENCIA: Esto eliminará TODOS los postulantes y datos relacionados. ¿Está seguro?')) {
        if (confirm('¿REALMENTE está seguro? Esta acción NO se puede deshacer.')) {
            window.location.href = 'limpiar_datos.php';
        }
    }
}

function confirmarResetSistema() {
    alert('Esta función está deshabilitada por seguridad. Contacte al administrador del sistema.');
}
</script>

<?php include 'includes/footer.php'; ?>