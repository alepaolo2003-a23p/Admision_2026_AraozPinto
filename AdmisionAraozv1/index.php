<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IESTP María Rosario Aráoz Pinto - Admisión 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #006b3f;
            --dark-green: #004d2e;
            --light-green: #e8f5e9;
            --orange: #ff8c42;
            --dark-bg: #1a1a1a;
            --gray-bg: #f5f5f5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Top Bar */
        .top-bar {
            background: var(--dark-green);
            color: white;
            padding: 10px 0;
            font-size: 0.9rem;
        }

        .top-bar i {
            margin-right: 8px;
        }

        /* Navigation */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: var(--dark-green) !important;
        }

        .logo-circle {
            width: 50px;
            height: 50px;
            background: var(--primary-green);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .brand-text h5 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--dark-green);
        }

        .brand-text p {
            margin: 0;
            font-size: 0.8rem;
            color: #666;
        }

        .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: 500;
            padding: 8px 20px !important;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-green) !important;
        }

        .btn-inscribirse {
            background: var(--primary-green);
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }

        .btn-inscribirse:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,107,63,0.3);
        }

        /* Hero Section */
        .hero-section {
            background: var(--primary-green);
            min-height: 600px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            opacity: 0.9;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-features {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }

        .hero-features li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .hero-features li i {
            color: #fff;
            font-size: 1.5rem;
            margin-right: 15px;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 50%;
        }

        .btn-iniciar {
            background: var(--orange);
            color: white;
            padding: 15px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            margin-top: 30px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .btn-iniciar:hover {
            background: #e67835;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255,140,66,0.4);
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: white;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon i {
            font-size: 2rem;
            color: var(--primary-green);
        }

        .feature-card h5 {
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--dark-green);
        }

        /* Carreras Section */
        .carreras-section {
            padding: 80px 0;
            background: var(--gray-bg);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark-green);
            margin-bottom: 15px;
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
        }

        .carrera-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: all 0.3s;
        }

        .carrera-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .carrera-image {
            height: 200px;
            background: var(--light-green);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .carrera-image img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .carrera-content {
            padding: 25px;
        }

        .carrera-content h5 {
            font-weight: bold;
            color: var(--dark-green);
            margin-bottom: 15px;
        }

        .btn-mas-detalles {
            width: 100%;
            padding: 12px;
            background: white;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-mas-detalles:hover {
            background: var(--primary-green);
            color: white;
        }

        /* Proceso Section */
        .proceso-section {
            padding: 80px 0;
            background: white;
        }

        .proceso-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            height: 100%;
        }

        .proceso-card:hover {
            border-color: var(--primary-green);
            box-shadow: 0 10px 30px rgba(0,107,63,0.1);
        }

        .proceso-number {
            width: 60px;
            height: 60px;
            background: #0066cc;
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .proceso-card h5 {
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--dark-green);
        }

        /* Requisitos Section */
        .requisitos-section {
            padding: 80px 0;
            background: var(--gray-bg);
        }

        .requisito-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .requisito-card:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .requisito-icon {
            width: 50px;
            height: 50px;
            background: var(--light-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .requisito-icon i {
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        /* Costo Section */
        .costo-section {
            background: #fff3e6;
            border: 3px solid #ffb366;
            border-radius: 15px;
            padding: 40px;
            margin-top: 40px;
        }

        .costo-section h3 {
            font-weight: bold;
            color: var(--dark-green);
            margin-bottom: 30px;
        }

        .costo-amount {
            background: white;
            border-left: 5px solid var(--primary-green);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .costo-amount h4 {
            color: var(--primary-green);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .cuenta-card {
            background: #e8e8e8;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .cuenta-numero {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-green);
            margin: 10px 0;
        }

        /* Cronograma Section */
        .cronograma-section {
            padding: 80px 0;
            background: white;
        }

        .cronograma-item {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .cronograma-item:hover {
            border-color: var(--primary-green);
            box-shadow: 0 5px 20px rgba(0,107,63,0.1);
        }

        .cronograma-left {
            display: flex;
            align-items: center;
        }

        .cronograma-icon {
            width: 50px;
            height: 50px;
            background: var(--light-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }

        .cronograma-icon i {
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-badge.en-curso {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .status-badge.proximo {
            background: #fff9c4;
            color: #f57f17;
        }

        .status-badge.pendiente {
            background: #e0e0e0;
            color: #757575;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-green);
            padding: 80px 0;
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Footer */
        .footer {
            background: var(--dark-bg);
            color: white;
            padding: 60px 0 20px;
        }

        .footer h5 {
            font-weight: bold;
            margin-bottom: 20px;
            color: white;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer ul li a:hover {
            color: var(--primary-green);
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: #999;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="bi bi-geo-alt-fill"></i>Calle José Martí 155 Lima, San Miguel - 15088 Perú
                </div>
                <div class="col-md-6 text-md-end">
                    <i class="bi bi-envelope-fill"></i>contacto@institutoaraozpinto.com
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="logo-circle"><img src="assets/images/logo.png" alt="alt" height="100%"/></div>
                <div class="brand-text">
                    <h5>María Rosario Aráoz Pinto</h5>
                    <p>Instituto de Educación Superior</p>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#carreras">Carreras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#proceso">Proceso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#requisitos">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cronograma">Cronograma</a>
                    </li>
                </ul>
                <button class="btn btn-inscribirse ms-3" onclick="location.href='inscripcion.php'">
                    INSCRIBIRSE <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>45 años<br>Creando<br>Profesionales de<br>Calidad</h1>
                    <ul class="hero-features">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            9 Carreras de alta demanda
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Certificados modulares
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Malla Curricular actualizada
                        </li>
                    </ul>
                    <button class="btn btn-iniciar" onclick="location.href='inscripcion.php'">
                        INICIA TU INSCRIPCIÓN <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="assets/images/estudiante.jpg" alt="Estudiante" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <h5>Experiencia</h5>
                        <p>Somos un instituto de prestigio con más de 40 años de experiencia formando profesionales competitivos.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5>Docentes Calificados</h5>
                        <p>Contamos con docentes altamente calificados que te guiarán en tu proceso de formación.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h5>Convenios</h5>
                        <p>Tenemos convenios con instituciones educativas para recibir múltiples beneficios.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h5>Materiales y Herramientas</h5>
                        <p>Brindamos todas las herramientas y materiales necesarios para tu desarrollo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carreras Section -->
    <section class="carreras-section" id="carreras">
        <div class="container">
            <div class="section-title">
                <h2>Carreras en Aráoz Pinto</h2>
                <p>El Instituto María Rosario Aráoz Pinto pone a disposición 9 carreras con alta demanda con el mejor plan formativo.</p>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/mecanica_automotriz.jpg" alt="Mecánica Automotriz">
                        </div>
                        <div class="carrera-content">
                            <h5>Mecánica Automotriz</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/contabilidad.jpg" alt="Contabilidad">
                        </div>
                        <div class="carrera-content">
                            <h5>Contabilidad</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/diseño_publicitario.jpg" alt="Diseño Publicitario">
                        </div>
                        <div class="carrera-content">
                            <h5>Diseño Publicitario</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/mecanica_produccion.jpg" alt="Mecánica de Producción">
                        </div>
                        <div class="carrera-content">
                            <h5>Mecánica de Producción</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/diseño_grafico.jpg" alt="Diseño Gráfico">
                        </div>
                        <div class="carrera-content">
                            <h5>Diseño Gráfico</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/construccion_civil.jpg" alt="Construcción Civil">
                        </div>
                        <div class="carrera-content">
                            <h5>Construcción Civil</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/DSI.jpg" alt="Desarrollo de Sistemas">
                        </div>
                        <div class="carrera-content">
                            <h5>Desarrollo de Sistemas</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/secretariado_ejecutivo.jpg" alt="Secretariado Ejecutivo">
                        </div>
                        <div class="carrera-content">
                            <h5>Secretariado Ejecutivo</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="carrera-card">
                        <div class="carrera-image">
                            <img src="assets/images/administracion.jpg" alt="Administración de Empresas">
                        </div>
                        <div class="carrera-content">
                            <h5>Administración de Empresas</h5>
                            <button class="btn btn-mas-detalles">Más Detalles</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Proceso Section -->
    <section class="proceso-section" id="proceso">
        <div class="container">
            <div class="section-title">
                <h2>Proceso de Admisión 2026</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="proceso-card">
                        <div class="proceso-number">1</div>
                        <h5>Inscripción Online</h5>
                        <p>Completa el formulario de solicitud</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="proceso-card">
                        <div class="proceso-number">2</div>
                        <h5>Evaluación</h5>
                        <p>Participa en prueba de admisión</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="proceso-card">
                        <div class="proceso-number">3</div>
                        <h5>Resultados</h5>
                        <p>Recibe tu resultado de admisión</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requisitos Section -->
    <section class="requisitos-section" id="requisitos">
        <div class="container">
            <div class="section-title">
                <h2>Requisitos para el Derecho de Postulación</h2>
                <p>Documentos obligatorios para completar tu inscripción</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="requisito-card">
                        <div class="requisito-icon">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Fotografía tamaño carné</h6>
                            <small class="text-muted">A colores con fondo blanco en formato PNG o JPG</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="requisito-card">
                        <div class="requisito-icon">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Documento de identidad</h6>
                            <small class="text-muted">Ambas caras en formato PDF</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="requisito-card">
                        <div class="requisito-icon">
                            <i class="bi bi-file-earmark-text-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Certificado de estudios secundarios</h6>
                            <small class="text-muted">Constancia de estudios en formato blanco como PDF</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="requisito-card">
                        <div class="requisito-icon">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Voucher de pago</h6>
                            <small class="text-muted">Comprobante de depósito de S/. 150.00 en formato PDF</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Costo Section -->
            <div class="costo-section">
                <h3>Costo de Postulación Aráoz Pinto</h3>
                
                <div class="costo-amount">
                    <h4>S/. 150.00 soles</h4>
                    <p class="mb-0">El costo del examen de admisión y prospecto debe depositarse en el Banco de la Nación a nuestra cuenta corriente mediante el agente o ventanilla.</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="cuenta-card">
                            <p class="mb-1 fw-bold">Modalidad: Ventanilla</p>
                            <div class="cuenta-numero">0000-289124</div>
                            <small>Número de cuenta corriente</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cuenta-card">
                            <p class="mb-1 fw-bold">Modalidad: Agente</p>
                            <div class="cuenta-numero">00000-289124</div>
                            <small>Número de cuenta corriente</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Importante:</strong> Conserva el voucher de pago como comprobante. Es necesario adjuntarlo en tu inscripción.
                </div>
            </div>
        </div>
    </section>

    <!-- Cronograma Section -->
    <section class="cronograma-section" id="cronograma">
        <div class="container">
            <div class="section-title">
                <h2>Cronograma de Admisión 2026</h2>
            </div>

            <div class="cronograma-item">
                <div class="cronograma-left">
                    <div class="cronograma-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Inscripción online</h5>
                        <p class="text-muted mb-0">20 - 11 - 2025</p>
                    </div>
                </div>
                <span class="status-badge en-curso">En curso</span>
            </div>

            <div class="cronograma-item">
                <div class="cronograma-left">
                    <div class="cronograma-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Prueba de admisión</h5>
                        <p class="text-muted mb-0">22 - 11 - 2025</p>
                    </div>
                </div>
                <span class="status-badge proximo">Próximo</span>
            </div>

            <div class="cronograma-item">
                <div class="cronograma-left">
                    <div class="cronograma-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Presentación de resultados</h5>
                        <p class="text-muted mb-0">11 - 12 - 2025</p>
                    </div>
                </div>
                <span class="status-badge pendiente">Pendiente</span>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>¿Listo para tu inscripción?</h2>
            <p class="lead">Completa tu solicitud ahora y sé parte de nuestra comunidad académica de excelencia</p>
            <button class="btn btn-iniciar btn-lg mt-3" onclick="location.href='inscripcion.php'">
                Iniciar Inscripción <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                            <div class="logo-circle"><img src="assets/images/logo.png" alt="alt" height="100%"/></div>
                        <div class="ms-3">
                            <h5 class="mb-0">María Rosario Aráoz Pinto</h5>
                            <p class=" mb-0" style="font-size: 0.9rem;">Instituto de Educación Superior<br>Tecnológico Público</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5>Enlaces Rápidos</h5>
                    <ul>
                        <li><a href="#carreras">Carreras</a></li>
                        <li><a href="#proceso">Proceso</a></li>
                        <li><a href="#cronograma">Cronograma</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contacto</h5>
                    <ul>
                        <li><i class="bi bi-envelope-fill"></i> contacto@institutoaraozpinto.com</li>
                        <li><i class="bi bi-geo-alt-fill"></i> Calle José Martí 155, San Miguel</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Horario de Atención</h5>
                    <p class="mb-0">Lun - Vie: 08:00 - 18:00</p>
                    <p class="mb-0">Sábado: 09:00 - 14:00</p>
                </div>
                                    <!-- Botón Panel Administrativo -->
                    <div class="mt-3">
                        <a href="admin/login.php" class="btn btn-sm btn-outline-light" style="border-radius: 8px;">
                            <i class="bi bi-shield-lock-fill"></i> Panel Administrativo
                        </a>
                    </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Instituto María Rosario Aráoz Pinto. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll para los enlaces de navegación
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animación al hacer scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Aplicar animación a las tarjetas
        document.querySelectorAll('.carrera-card, .proceso-card, .requisito-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });

        // Destacar sección activa en navbar
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').substring(1) === current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>