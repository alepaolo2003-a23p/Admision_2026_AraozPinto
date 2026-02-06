<?php
// admin/logs.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();
verificarRol(['admin']); // Solo administradores

$db = conectarDB();

// Filtros
$filtro_accion = $_GET['accion'] ?? '';
$filtro_usuario = $_GET['usuario'] ?? '';
$fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-d', strtotime('-7 days'));
$fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');

// Construir query
$sql = "SELECT l.*, u.username, u.nombre_completo 
        FROM logs_sistema l
        LEFT JOIN usuarios_admin u ON l.usuario_id = u.id
        WHERE DATE(l.fecha_hora) BETWEEN ? AND ?";

$params = [$fecha_desde, $fecha_hasta];

if ($filtro_accion) {
    $sql .= " AND l.accion = ?";
    $params[] = $filtro_accion;
}

if ($filtro_usuario) {
    $sql .= " AND l.usuario_id = ?";
    $params[] = $filtro_usuario;
}

$sql .= " ORDER BY l.fecha_hora DESC LIMIT 500";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll();

// Obtener tipos de acciones
$acciones = $db->query("SELECT DISTINCT accion FROM logs_sistema ORDER BY accion")->fetchAll(PDO::FETCH_COLUMN);

// Obtener usuarios
$usuarios = $db->query("SELECT id, username, nombre_completo FROM usuarios_admin ORDER BY nombre_completo")->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-activity"></i> Logs del Sistema</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportarLogs()">
                        <i class="bi bi-download"></i> Exportar
                    </button>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" value="<?php echo $fecha_desde; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" value="<?php echo $fecha_hasta; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Acción</label>
                            <select class="form-select" name="accion">
                                <option value="">Todas</option>
                                <?php foreach ($acciones as $accion): ?>
                                <option value="<?php echo $accion; ?>" <?php echo $filtro_accion == $accion ? 'selected' : ''; ?>>
                                    <?php echo ucwords(str_replace('_', ' ', $accion)); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Usuario</label>
                            <select class="form-select" name="usuario">
                                <option value="">Todos</option>
                                <?php foreach ($usuarios as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php echo $filtro_usuario == $user['id'] ? 'selected' : ''; ?>>
                                    <?php echo $user['nombre_completo']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Filtrar
                            </button>
                            <a href="logs.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Logs -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Registros de Actividad (<?php echo count($logs); ?> resultados)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha/Hora</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Descripción</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs as $log): ?>
                                <tr>
                                    <td><?php echo $log['id']; ?></td>
                                    <td><?php echo date('d/m/Y H:i:s', strtotime($log['fecha_hora'])); ?></td>
                                    <td>
                                        <?php 
                                        if ($log['username']) {
                                            echo '<strong>' . htmlspecialchars($log['nombre_completo']) . '</strong><br>';
                                            echo '<small class="text-muted">(' . htmlspecialchars($log['username']) . ')</small>';
                                        } else {
                                            echo '<span class="text-muted">Sistema</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = 'bg-secondary';
                                        switch($log['accion']) {
                                            case 'login': $badge_class = 'bg-success'; break;
                                            case 'logout': $badge_class = 'bg-info'; break;
                                            case 'eliminar_postulante': $badge_class = 'bg-danger'; break;
                                            case 'inscripcion_nueva': $badge_class = 'bg-primary'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucwords(str_replace('_', ' ', $log['accion'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?php echo htmlspecialchars($log['descripcion']); ?></small>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo $log['ip_address']; ?></small>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (count($logs) == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle"></i> No se encontraron registros con los filtros seleccionados
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Total de Registros</h6>
                            <h3><?php echo $db->query("SELECT COUNT(*) FROM logs_sistema")->fetchColumn(); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Registros Hoy</h6>
                            <h3><?php echo $db->query("SELECT COUNT(*) FROM logs_sistema WHERE DATE(fecha_hora) = CURDATE()")->fetchColumn(); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Última Actividad</h6>
                            <h3>
                                <?php 
                                $ultima = $db->query("SELECT fecha_hora FROM logs_sistema ORDER BY fecha_hora DESC LIMIT 1")->fetchColumn();
                                echo $ultima ? date('H:i:s', strtotime($ultima)) : 'N/A';
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function exportarLogs() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    window.location.href = 'exportar_logs.php?' + params.toString();
}
</script>

<?php include 'includes/footer.php'; ?>