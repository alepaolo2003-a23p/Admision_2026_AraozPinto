<?php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$db = conectarDB();

$sql = "SELECT d.*, p.nombres, p.apellidos, p.dni 
        FROM documentos d
        INNER JOIN postulantes p ON d.postulante_id = p.id
        ORDER BY d.fecha_subida DESC
        LIMIT 100";

$documentos = $db->query($sql)->fetchAll();

include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 60px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="bi bi-file-earmark-text-fill"></i> Gestión de Documentos</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Postulante</th>
                                    <th>DNI</th>
                                    <th>Tipo Documento</th>
                                    <th>Archivo</th>
                                    <th>Fecha Subida</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($documentos as $doc): ?>
                                <tr>
                                    <td><?php echo $doc['nombres'] . ' ' . $doc['apellidos']; ?></td>
                                    <td><?php echo $doc['dni']; ?></td>
                                    <td><?php echo ucwords(str_replace('_', ' ', $doc['tipo_documento'])); ?></td>
                                    <td><small><?php echo $doc['nombre_archivo']; ?></small></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($doc['fecha_subida'])); ?></td>
                                    <td>
                                        <?php
                                        $badge = '';
                                        switch($doc['estado_verificacion']) {
                                            case 'pendiente': $badge = 'bg-warning text-dark'; break;
                                            case 'aprobado': $badge = 'bg-success'; break;
                                            case 'rechazado': $badge = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $badge; ?>">
                                            <?php echo ucfirst($doc['estado_verificacion']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="../<?php echo $doc['ruta_archivo']; ?>" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="bi bi-download"></i>
                                        </a>
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

<?php include 'includes/footer.php'; ?>
*/
?>