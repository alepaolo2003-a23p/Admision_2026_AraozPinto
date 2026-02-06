<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - IESTP MRAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #006b3f;
            --dark-green: #004d2e;
            --light-green: #e8f5e9;
            --sidebar-width: 230px;
            --navbar-height: 80px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }
        
        /* Navbar Superior */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 0;
            height: var(--navbar-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .navbar-brand {
            color: white !important;
            padding: 15px 20px;
            font-weight: bold;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            margin: 0;
            width: var(--sidebar-width);
            font-size: 1.1rem;
        }
        
        .navbar-brand i {
            margin-right: 8px;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 1020;
            width: var(--sidebar-width);
            padding: 20px 0;
            background: var(--dark-green);
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar-sticky {
            position: relative;
            height: 100%;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 3px 10px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.15);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            font-size: 1.1rem;
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            padding: 15px 20px 5px;
            margin-top: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* User Dropdown en Navbar */
        .user-dropdown {
            margin-left: auto;
            padding: 0 15px;
        }
        
        .user-dropdown .btn {
            background: transparent;
            border: none;
            color: #333;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }
        
        .user-dropdown .btn:hover {
            background: #f5f5f5;
            border-radius: 8px;
        }
        
        .user-dropdown .btn i {
            font-size: 1.3rem;
        }
        
        .user-dropdown .dropdown-menu {
            right: 0;
            left: auto;
            min-width: 220px;
            margin-top: 8px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .user-dropdown .dropdown-item {
            padding: 10px 20px;
        }
        
        .user-dropdown .dropdown-item i {
            margin-right: 10px;
            width: 20px;
        }
        
        /* Main Content */
        main {
            margin-left: var(--sidebar-width);
            margin-top: 140px;
            padding: 30px;
            min-height: calc(100vh - 140px);
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: white;
            border-bottom: 2px solid #f0f0f0;
            font-weight: 600;
            padding: 15px 20px;
        }
        
        /* Stat Cards */
        .stat-card {
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s;
            color: white;
            padding: 20px;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        
        .stat-icon {
            font-size: 3rem;
            opacity: 0.3;
        }
        
        /* Tables */
        .table {
            background: white;
        }
        
        .table thead {
            background: var(--light-green);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .btn-primary:hover {
            background: var(--dark-green);
            border-color: var(--dark-green);
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                transition: margin-left 0.3s;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            main {
                margin-left: 0;
            }
            
            .navbar-brand {
                width: auto;
                min-width: 150px;
            }
            
            .user-dropdown .btn span {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            main {
                padding: 15px;
            }
            
            .stat-card {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="alt" height="60px" width="auto"/>
        </a>
        <button class="navbar-toggler d-md-none ms-auto me-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="user-dropdown">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <span><?php echo obtenerNombreUsuario(); ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="mi_perfil.php"><i class="bi bi-person"></i> Mi Perfil</a></li>
                    <li><a class="dropdown-item" href="configuracion.php"><i class="bi bi-gear"></i> Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>