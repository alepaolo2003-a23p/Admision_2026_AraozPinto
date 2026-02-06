<?php
// admin/exportar.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

verificarSesion();

$tipo = $_GET['tipo'] ?? 'excel';
$filtro_estado = $_GET['estado'] ?? '';
$filtro_carrera = $_GET['carrera'] ?? '';
$buscar = $_GET['buscar'] ?? '';

$db = conectarDB();

// Construir query
$sql = "SELECT p.id, p.nombres, p.apellidos, p.dni, p.email, p.telefono, 
        p.edad, p.estado_inscripcion, p.fecha_registro,
        prog.nombre as programa_primera,
        ie.codigo_inscripcion, ie.pago_realizado
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
    $sql .= " AND (p.nombres LIKE ? OR p.apellidos LIKE ? OR p.dni LIKE ?)";
    $busqueda = "%{$buscar}%";
    $params[] = $busqueda;
    $params[] = $busqueda;
    $params[] = $busqueda;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$postulantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($tipo === 'excel') {
    // Exportar a CSV (compatible con Excel)
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="postulantes_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    
    // BOM para UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Encabezados
    fputcsv($output, ['ID', 'Nombres', 'Apellidos', 'DNI', 'Email', 'Teléfono', 'Edad', 'Programa', 'Código', 'Pago', 'Estado', 'Fecha Registro']);
    
    // Datos
    foreach ($postulantes as $p) {
        fputcsv($output, [
            $p['id'],
            $p['nombres'],
            $p['apellidos'],
            $p['dni'],
            $p['email'],
            $p['telefono'],
            $p['edad'],
            $p['programa_primera'],
            $p['codigo_inscripcion'],
            $p['pago_realizado'] ? 'Sí' : 'No',
            ucfirst($p['estado_inscripcion']),
            date('d/m/Y H:i', strtotime($p['fecha_registro']))
        ]);
    }
    
    fclose($output);
    
} elseif ($tipo === 'pdf') {
    // Para PDF necesitarías una librería como TCPDF o FPDF
    // Por ahora, redireccionar con mensaje
    header('Location: postulantes.php?error=PDF en desarrollo');
}

exit;
?>