<?php
// admin/postulantes.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();

// Filtros
$filtro_estado = $_GET['estado'] ?? '';
$filtro_carrera = $_GET['carrera'] ?? '';
$buscar = $_GET['buscar'] ?? '';

// Construir query con filtros
$sql = "SELECT p.id, p.nombres, p.apellidos, p.dni, p.email, p.telefono, 
        p.fecha_nacimiento, p.edad, p.es_menor_edad, p.estado_inscripcion, 
        p.fecha_registro,
        prog.nombre as programa_primera,
        oc.turno as turno_primera,
        ie.codigo_inscripcion,
        ie.pago_realizado
        FROM postulantes p
        LEFT JOIN opciones_carrera oc ON p.id = oc.postulante_id AND oc.orden_preferencia = 'primera'
        LEFT JOIN programas_estudio prog ON oc.programa_id = prog.id
        LEFT JOIN inscripciones_examen ie ON p.id = ie.postulante_id
        WHERE 1=1";

$params = [];

if ($filtro_estado) {
    $sql .= " AND p.estado_inscripcion = ?";
    $params[] = $filtro_estado;
}

if ($filtro_carrera) {
    $sql .= " AND prog.id = ?";
    $params[] = $filtro_carrera;
}

if ($buscar) {
    $sql .= " AND (p.nombres LIKE ? OR p.apellidos LIKE ? OR p.dni LIKE ? OR p.email LIKE ?)";
    $busqueda = "%{$buscar}%";
    $params[] = $busqueda;
    $params[] = $busqueda;
    $params[] = $busqueda;
    $params[] = $busqueda;
}

$sql .= " ORDER BY p.fecha_registro DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$postulantes = $stmt->fetchAll();

// Obtener carreras para filtro
$carreras = $db->query("SELECT id, nombre FROM programas_estudio ORDER BY nombre")->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-people-fill"></i> Gestión de Postulantes</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportarExcel()">
                            <i class="bi bi-file-excel"></i> Exportar Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="exportarPDF()">
                            <i class="bi bi-file-pdf"></i> Exportar PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" class="form-control" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>" placeholder="Nombre, DNI o Email">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado">
                                <option value="">Todos</option>
                                <option value="pendiente" <?php echo $filtro_estado == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="completado" <?php echo $filtro_estado == 'completado' ? 'selected' : ''; ?>>Completado</option>
                                <option value="rechazado" <?php echo $filtro_estado == 'rechazado' ? 'selected' : ''; ?>>Rechazado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Carrera</label>
                            <select class="form-select" name="carrera">
                                <option value="">Todas</option>
                                <?php foreach ($carreras as $carrera): ?>
                                <option value="<?php echo $carrera['id']; ?>" <?php echo $filtro_carrera == $carrera['id'] ? 'selected' : ''; ?>>
                                    <?php echo $carrera['nombre']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de postulantes -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lista de Postulantes (<?php echo count($postulantes); ?>)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DNI</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Edad</th>
                                    <th>Programa</th>
                                    <th>Código</th>
                                    <th>Pago</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($postulantes as $p): ?>
                                <tr>
                                    <td><?php echo $p['id']; ?></td>
                                    <td><?php echo $p['dni']; ?></td>
                                    <td><?php echo $p['nombres'] . ' ' . $p['apellidos']; ?></td>
                                    <td><?php echo $p['email']; ?></td>
                                    <td>
                                        <?php echo $p['edad']; ?> años
                                        <?php if ($p['es_menor_edad']): ?>
                                        <span class="badge bg-warning text-dark">Menor</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $p['programa_primera'] ?? 'Sin programa'; ?></td>
                                    <td>
                                        <?php if ($p['codigo_inscripcion']): ?>
                                        <small><?php echo $p['codigo_inscripcion']; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($p['pago_realizado']): ?>
                                        <span class="badge bg-success">Pagado</span>
                                        <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($p['estado_inscripcion']) {
                                            case 'pendiente': $badge_class = 'bg-warning text-dark'; break;
                                            case 'completado': $badge_class = 'bg-success'; break;
                                            case 'rechazado': $badge_class = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo ucfirst($p['estado_inscripcion']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($p['fecha_registro'])); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="ver_postulante.php?id=<?php echo $p['id']; ?>" class="btn btn-primary" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="editar_postulante.php?id=<?php echo $p['id']; ?>" class="btn btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" onclick="eliminarPostulante(<?php echo $p['id']; ?>)" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
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

<script>
function exportarExcel() {
    window.location.href = 'exportar.php?tipo=excel&' + window.location.search.substring(1);
}

function exportarPDF() {
    window.location.href = 'exportar.php?tipo=pdf&' + window.location.search.substring(1);
}

function eliminarPostulante(id) {
    if (confirm('¿Está seguro de eliminar este postulante? Esta acción no se puede deshacer.')) {
        window.location.href = 'eliminar_postulante.php?id=' + id;
    }
}
</script>

<?php include 'includes/footer.php'; ?>