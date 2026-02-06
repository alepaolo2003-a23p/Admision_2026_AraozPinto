<?php
// ========================================
// admin/programas.php
// ========================================
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();
$programas = $db->query("SELECT * FROM programas_estudio ORDER BY nombre")->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-book-fill"></i> Programas de Estudio</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Duración</th>
                                    <th>Modalidad</th>
                                    <th>Estado</th>
                                    <th>Postulantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($programas as $programa): 
                                    $stmt = $db->prepare("SELECT COUNT(*) FROM opciones_carrera WHERE programa_id = ? AND orden_preferencia = 'primera'");
                                    $stmt->execute([$programa['id']]);
                                    $total_postulantes = $stmt->fetchColumn();
                                ?>
                                <tr>
                                    <td><?php echo $programa['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($programa['nombre']); ?></strong></td>
                                    <td><?php echo $programa['duracion_semestres']; ?> semestres</td>
                                    <td><?php echo ucfirst($programa['modalidad']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $programa['estado'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $programa['estado'] ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $total_postulantes; ?></td>
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

<?php include 'includes/footer.php'; ?>