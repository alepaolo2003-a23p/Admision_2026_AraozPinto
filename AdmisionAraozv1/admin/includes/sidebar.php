<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'postulantes.php') ? 'active' : ''; ?>" href="postulantes.php">
                    <i class="bi bi-people-fill"></i>
                    Postulantes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'examenes.php') ? 'active' : ''; ?>" href="examenes.php">
                    <i class="bi bi-clipboard-check-fill"></i>
                    Exámenes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'programas.php') ? 'active' : ''; ?>" href="programas.php">
                    <i class="bi bi-book-fill"></i>
                    Programas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'documentos.php') ? 'active' : ''; ?>" href="documentos.php">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    Documentos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'reportes.php') ? 'active' : ''; ?>" href="reportes.php">
                    <i class="bi bi-graph-up"></i>
                    Reportes
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white">
            <span>Administración</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'usuarios.php') ? 'active' : ''; ?>" href="usuarios.php">
                    <i class="bi bi-person-badge-fill"></i>
                    Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'logs.php') ? 'active' : ''; ?>" href="logs.php">
                    <i class="bi bi-activity"></i>
                    Logs del Sistema
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'configuracion.php') ? 'active' : ''; ?>" href="configuracion.php">
                    <i class="bi bi-gear-fill"></i>
                    Configuración
                </a>
            </li>
        </ul>
    </div>
</nav>