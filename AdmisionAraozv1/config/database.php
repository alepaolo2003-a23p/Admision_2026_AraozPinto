<?php
// config/database.php

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'admision_mrap');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Función para conectar a la base de datos
 * @return PDO
 */
function conectarDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
        
    } catch (PDOException $e) {
        error_log("Error de conexión: " . $e->getMessage());
        throw new Exception("Error al conectar con la base de datos");
    }
}

/**
 * Función para ejecutar consultas preparadas
 * @param PDO $db
 * @param string $sql
 * @param array $params
 * @return PDOStatement
 */
function ejecutarConsulta($db, $sql, $params = []) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Error en consulta: " . $e->getMessage());
        throw new Exception("Error al ejecutar la consulta");
    }
}

/**
 * Función para sanitizar datos de entrada
 * @param mixed $data
 * @return mixed
 */
function limpiarDatos($data) {
    if (is_array($data)) {
        return array_map('limpiarDatos', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

/**
 * Verificar conexión a la base de datos
 * @return bool
 */
function verificarConexion() {
    try {
        $db = conectarDB();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>