<?php
// admin/includes/auth.php

/**
 * Verificar si el usuario está autenticado
 */
function verificarSesion() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Verificar si el usuario tiene un rol específico
 */
function verificarRol($roles_permitidos = []) {
    verificarSesion();
    
    if (!empty($roles_permitidos) && !in_array($_SESSION['admin_rol'], $roles_permitidos)) {
        header('Location: index.php?error=acceso_denegado');
        exit;
    }
}

/**
 * Cerrar sesión
 */
function cerrarSesion() {
    session_destroy();
    header('Location: login.php');
    exit;
}

/**
 * Obtener el nombre del usuario actual
 */
function obtenerNombreUsuario() {
    return $_SESSION['admin_nombre'] ?? 'Usuario';
}

/**
 * Obtener el rol del usuario actual
 */
function obtenerRolUsuario() {
    return $_SESSION['admin_rol'] ?? '';
}
?>