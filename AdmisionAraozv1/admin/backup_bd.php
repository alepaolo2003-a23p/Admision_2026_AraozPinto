<?php
// admin/backup_bd.php
session_start();
require_once '../config/database.php';
require_once 'includes/auth.php';

// Verificar permisos (Solo Admin)
verificarSesion();
verificarRol(['admin']);

// Configuración del archivo
$fecha = date('Y-m-d_H-i-s');
$filename = "backup_admision_mrap_{$fecha}.sql";

// Encabezados para forzar la descarga
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $db = conectarDB();
    
    // 1. Obtener lista de tablas
    $tables = [];
    $query = $db->query('SHOW TABLES');
    while ($row = $query->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }

    // Inicio del archivo SQL
    echo "-- Backup Sistema de Admisión MRAP\n";
    echo "-- Generado el: " . date('d/m/Y H:i:s') . "\n";
    echo "-- Host: " . DB_HOST . "\n";
    echo "-- Base de datos: " . DB_NAME . "\n";
    echo "-- --------------------------------------------------------\n\n";
    echo "SET FOREIGN_KEY_CHECKS=0;\n";
    echo "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    echo "SET time_zone = \"+00:00\";\n\n";

    // 2. Recorrer tablas
    foreach ($tables as $table) {
        // Estructura de la tabla
        echo "--\n-- Estructura de tabla para la tabla `$table`\n--\n\n";
        echo "DROP TABLE IF EXISTS `$table`;\n";
        
        $createTable = $db->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
        echo $createTable['Create Table'] . ";\n\n";

        // Datos de la tabla
        echo "--\n-- Volcado de datos para la tabla `$table`\n--\n\n";
        
        $rows = $db->query("SELECT * FROM `$table`");
        $numRows = $rows->rowCount();
        
        if ($numRows > 0) {
            // Obtener columnas para saber tipos de datos si fuera necesario (opcional)
            // Aquí hacemos un insert genérico
            
            while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                $values = [];
                foreach ($row as $value) {
                    if ($value === null) {
                        $values[] = "NULL";
                    } else {
                        // Escapar comillas y caracteres especiales
                        $value = addslashes($value);
                        $value = str_replace("\n", "\\n", $value);
                        $value = str_replace("\r", "\\r", $value);
                        $values[] = "'$value'";
                    }
                }
                
                echo "INSERT INTO `$table` VALUES (" . implode(', ', $values) . ");\n";
            }
        }
        echo "\n";
    }

    echo "SET FOREIGN_KEY_CHECKS=1;\n";
    echo "-- Fin del backup --";

} catch (Exception $e) {
    // En caso de error, intentar enviar un archivo de texto con el error (si no se ha enviado output aún)
    echo "-- Error al generar backup: " . $e->getMessage();
}
exit;
?>