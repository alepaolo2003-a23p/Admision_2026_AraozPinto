<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Inscripción - IESTP María Rosario Araoz Pinto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #006b3f;
            --dark-green: #004d2e;
            --light-green: #e8f5e9;
            --orange: #ff8c42;
            --dark-bg: #1a1a1a;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            padding: 0;
        }
        
        /* Top Bar */
        .top-bar {
            background: var(--dark-green);
            color: white;
            padding: 10px 0;
            font-size: 0.9rem;
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

        .btn-volver {
            background: var(--primary-green);
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            text-decoration: none;
        }

        .btn-volver:hover {
            background: var(--dark-green);
            color: white;
        }
        
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .header-card {
            background: white;
            border-radius: 0;
            padding: 30px;
            margin-bottom: 10px;
            box-shadow: none;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header-card h1 {
            color: #1a1a1a;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .header-card .subtitle {
            color: #666;
            font-size: 0.95rem;
            margin: 0;
        }

        .btn-volver-inicio {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .btn-volver-inicio:hover {
            color: var(--dark-green);
        }

        .btn-volver-inicio i {
            margin-right: 8px;
        }
        
        .form-card {
            background: white;
            border-radius: 0;
            padding: 40px;
            box-shadow: none;
            margin-bottom: 0;
            border: 1px solid #e0e0e0;
        }
        
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            padding: 0;
        }
        
        .progress-step {
            flex: 1;
            text-align: center;
            position: relative;
        }
        
        .progress-step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: -50%;
            right: 50%;
            height: 2px;
            background: #e0e0e0;
            z-index: 0;
        }
        
        .progress-step:first-child::before {
            display: none;
        }
        
        .progress-step.active::before,
        .progress-step.completed::before {
            background: var(--primary-green);
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e0e0e0;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #999;
            transition: all 0.3s;
            position: relative;
            z-index: 1;
        }
        
        .progress-step.active .step-circle {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            transform: scale(1.1);
        }
        
        .progress-step.completed .step-circle {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
        
        .step-label {
            font-size: 0.8rem;
            color: #999;
            font-weight: 500;
        }
        
        .progress-step.active .step-label {
            color: #1a1a1a;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(0, 107, 63, 0.25);
        }
        
        .btn-custom-primary {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-custom-primary:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 107, 63, 0.3);
        }
        
        .btn-custom-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-custom-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .alert-custom {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .edad-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 5px;
        }
        
        .edad-badge.mayor {
            background: #dcfce7;
            color: #166534;
        }
        
        .edad-badge.menor {
            background: #fef3c7;
            color: #92400e;
        }
        
        .section-title {
            color: #1a1a1a;
            font-weight: bold;
            margin-bottom: 30px;
            padding-bottom: 0;
            border-bottom: none;
            font-size: 1.3rem;
        }
        
        .declaration-box {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-green);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .required-star {
            color: #dc2626;
        }
        
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .file-upload-label {
            display: block;
            padding: 15px;
            background: #f8f9fa;
            border: 2px dashed #ced4da;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload-label:hover {
            border-color: var(--primary-green);
            background: #e8f5e9;
        }
        
        .file-upload-label i {
            font-size: 2rem;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        .data-preview-box {
            background: white;
            border: 2px solid var(--primary-green);
            border-radius: 8px;
            padding: 15px;
        }

        .data-preview-box p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="bi bi-geo-alt-fill"></i> Calle José Martí 155 Lima, San Miguel - 15088 Perú
                </div>
                <div class="col-md-6 text-md-end">
                    <i class="bi bi-envelope-fill"></i> contacto@institutoaraozpinto.com
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                            <div class="logo-circle"><img src="assets/images/logo.png" alt="alt" height="100%"/></div>
                <div class="brand-text">
                    <h5>María Rosario Araoz Pinto</h5>
                    <p>Instituto de Educación Superior</p>
                </div>
            </a>
            <a href="index.php" class="btn-volver">
                <i class="bi bi-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </nav>

    <div class="container main-container">
        <!-- Header -->
        <div class="header-card">
            <a href="index.php" class="btn-volver-inicio">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
            <h1>Formulario de Inscripción</h1>
            <p class="subtitle">Admisión 2026 - Instituto María Rosario Araoz Pinto</p>
        </div>

        <!-- Alert Area -->
        <div id="alertArea"></div>

        <!-- Progress Steps -->
        <div class="form-card">
            <div class="progress-steps">
                <div class="progress-step active" id="progress-1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Paso 1</div>
                </div>
                <div class="progress-step" id="progress-2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Paso 2</div>
                </div>
                <div class="progress-step" id="progress-3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Paso 3</div>
                </div>
                <div class="progress-step" id="progress-4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Paso 4</div>
                </div>
                <div class="progress-step" id="progress-5">
                    <div class="step-circle">5</div>
                    <div class="step-label">Paso 5</div>
                </div>
            </div>

        <!-- Form -->
        <form id="inscripcionForm" method="POST" action="procesar_inscripcion.php" enctype="multipart/form-data">
            
            <!-- Step 1: Información Personal -->
            <div class="step-content active" id="step-1">
                <h3 class="section-title">Información Personal</h3>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombres <span class="required-star">*</span></label>
                            <input type="text" class="form-control" name="nombres" id="nombres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellidos <span class="required-star">*</span></label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">DNI <span class="required-star">*</span></label>
                            <input type="text" class="form-control" name="dni" id="dni" maxlength="8" pattern="[0-9]{8}" required>
                            <small class="text-muted">8 dígitos numéricos</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Nacimiento <span class="required-star">*</span></label>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>
                            <div id="edadDisplay"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="required-star">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="+51 999 999 999">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea class="form-control" name="direccion" id="direccion" rows="2"></textarea>
                    </div>
            </div>

            <!-- Step 2: Información Académica -->
            <div class="step-content" id="step-2">
                <h3 class="section-title">Información Académica</h3>
                    
                    <div class="mb-3">
                        <label class="form-label">Colegio de Procedencia <span class="required-star">*</span></label>
                        <input type="text" class="form-control" name="colegio_procedencia" id="colegio_procedencia" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nivel Educativo <span class="required-star">*</span></label>
                            <select class="form-select" name="grado_actual" id="grado_actual" required>
                                <option value="">Seleccione...</option>
                                <option value="secundaria_incompleta">Educación Secundaria Incompleta</option>
                                <option value="secundaria_completa">Educación Secundaria Completa</option>
                                <option value="tecnica_curso">Educación Técnica en Curso</option>
                                <option value="tecnica_completa">Educación Técnica Completa</option>
                                <option value="tecnica_incompleta">Educación Técnica Incompleta</option>
                                <option value="universitaria_curso">Educación Universitaria en Curso</option>
                                <option value="universitaria_completa">Educación Universitaria Completa</option>
                                <option value="universitaria_incompleta">Educación Universitaria Incompleta</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Promedio Último Año</label>
                            <input type="number" class="form-control" name="promedio_ultimo" id="promedio_ultimo" min="0" max="20" step="0.01" placeholder="15.50">
                        </div>
                    </div>
            </div>

            <!-- Step 3: Selección de Programas -->
            <div class="step-content" id="step-3">
                <h3 class="section-title">Selección de Programas</h3>
                    <p class="text-muted mb-4">Elige tu primera y segunda opción de carrera con su respectivo turno</p>

                    <!-- Primera Opción -->
                    <div class="declaration-box">
                        <h5 class="text-primary mb-3"><i class="bi bi-1-circle-fill"></i> Primera Opción</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Carrera <span class="required-star">*</span></label>
                                <select class="form-select" name="programa_primera" id="programa_primera" required>
                                    <option value="">Seleccione una carrera...</option>
                                    <option value="1">Administración de Empresas</option>
                                    <option value="2">Contabilidad</option>
                                    <option value="3">Construcción Civil</option>
                                    <option value="4">Desarrollo de Sistemas de Información</option>
                                    <option value="5">Diseño Gráfico</option>
                                    <option value="6">Diseño Publicitario</option>
                                    <option value="7">Mecánica Automotriz</option>
                                    <option value="8">Mecánica de Producción</option>
                                    <option value="9">Secretariado Ejecutivo</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Turno <span class="required-star">*</span></label>
                                <select class="form-select" name="turno_primera" id="turno_primera" required>
                                    <option value="">Seleccione un turno...</option>
                                    <option value="diurno">Diurno</option>
                                    <option value="nocturno">Nocturno</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda Opción -->
                    <div class="declaration-box">
                        <h5 class="text-secondary mb-3"><i class="bi bi-2-circle-fill"></i> Segunda Opción</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Carrera <span class="required-star">*</span></label>
                                <select class="form-select" name="programa_segunda" id="programa_segunda" required>
                                    <option value="">Seleccione una carrera...</option>
                                    <option value="1">Administración de Empresas</option>
                                    <option value="2">Contabilidad</option>
                                    <option value="3">Construcción Civil</option>
                                    <option value="4">Desarrollo de Sistemas de Información</option>
                                    <option value="5">Diseño Gráfico</option>
                                    <option value="6">Diseño Publicitario</option>
                                    <option value="7">Mecánica Automotriz</option>
                                    <option value="8">Mecánica de Producción</option>
                                    <option value="9">Secretariado Ejecutivo</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Turno <span class="required-star">*</span></label>
                                <select class="form-select" name="turno_segunda" id="turno_segunda" required>
                                    <option value="">Seleccione un turno...</option>
                                    <option value="diurno">Diurno</option>
                                    <option value="nocturno">Nocturno</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Apoderado -->
                    <h5 class="text-dark mt-4 mb-3"><i class="bi bi-person-badge-fill"></i> Información del Apoderado</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo del Apoderado <span class="required-star">*</span></label>
                            <input type="text" class="form-control" name="nombre_apoderado" id="nombre_apoderado" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">DNI del Apoderado <span class="required-star">*</span></label>
                            <input type="text" class="form-control" name="dni_apoderado" id="dni_apoderado" maxlength="8" pattern="[0-9]{8}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Parentesco <span class="required-star">*</span></label>
                            <select class="form-select" name="parentesco" id="parentesco" required>
                                <option value="">Seleccione...</option>
                                <option value="padre">Padre</option>
                                <option value="madre">Madre</option>
                                <option value="tutor">Tutor</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono del Apoderado</label>
                            <input type="tel" class="form-control" name="telefono_apoderado" id="telefono_apoderado">
                        </div>
                    </div>

                    <!-- Términos y Condiciones -->
                    <div class="declaration-box bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="acepta_terminos" id="acepta_terminos" required>
                            <label class="form-check-label" for="acepta_terminos">
                                <strong>Acepto los términos y condiciones</strong> y confirmo que toda la información proporcionada es veraz y completa. <span class="required-star">*</span>
                            </label>
                        </div>
                    </div>
            </div>

            <!-- Step 4: Documentos -->
            <div class="step-content" id="step-4">
                <h3 class="section-title">Documentación Requerida</h3>
                    
                    <div class="mb-4">
                        <label class="form-label">Copia de DNI (PDF o Imagen) <span class="required-star">*</span></label>
                        <label class="file-upload-label" for="documento_dni">
                            <i class="bi bi-cloud-upload-fill d-block"></i>
                            <span>Haz clic para seleccionar tu DNI</span>
                            <small class="d-block text-muted mt-2">Formatos: PDF, JPG, PNG (Máx. 5MB)</small>
                        </label>
                        <input type="file" class="form-control d-none" name="documento_dni" id="documento_dni" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div id="filename_dni" class="mt-2 text-success"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Certificados de Calificaciones (PDF) <span class="required-star">*</span></label>
                        <label class="file-upload-label" for="certificados">
                            <i class="bi bi-cloud-upload-fill d-block"></i>
                            <span>Haz clic para seleccionar tus certificados</span>
                            <small class="d-block text-muted mt-2">Formatos: PDF (Máx. 5MB)</small>
                        </label>
                        <input type="file" class="form-control d-none" name="certificados" id="certificados" accept=".pdf" required>
                        <div id="filename_cert" class="mt-2 text-success"></div>
                    </div>
            </div>

            <!-- Step 5: Declaraciones Juradas -->
            <div class="step-content" id="step-5">
                <h3 class="section-title">Declaraciones Juradas</h3>
                    
                    <div class="alert alert-info alert-custom">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Importante:</strong> Completa y firma digitalmente tus declaraciones juradas haciendo clic en el botón de abajo.
                    </div>

                    <div class="declaration-box bg-light p-4 mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="bi bi-pen-fill"></i> Firma Digital de Declaraciones
                        </h5>
                        <p class="mb-3">Para completar tu inscripción, necesitas firmar digitalmente las declaraciones juradas requeridas.</p>
                        
                        <!-- Información que se autocompletará -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Dirección Completa <span class="required-star">*</span></label>
                                <textarea class="form-control" id="direccion_firma" rows="2" placeholder="Ingresa tu dirección completa" required></textarea>
                                <small class="text-muted">Esta información se usará en las declaraciones juradas</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Datos para las Declaraciones</label>
                                <div class="data-preview-box">
                                    <p class="mb-1"><strong>Nombre:</strong> <span id="nombre_preview">-</span></p>
                                    <p class="mb-1"><strong>DNI:</strong> <span id="dni_preview">-</span></p>
                                    <p class="mb-0"><strong>Edad:</strong> <span id="edad_preview">-</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-custom-primary btn-lg" id="btnFirmarDeclaraciones">
                                <i class="bi bi-pen-fill"></i> Ir a Firmar Declaraciones Digitalmente
                            </button>
                            <small class="text-muted text-center">
                                Se abrirá una nueva pestaña donde podrás completar y firmar tus declaraciones
                            </small>
                        </div>
                    </div>

                    <div class="mb-4 mt-4">
                        <label class="form-label">Declaraciones Juradas Firmadas (PDF) <span class="required-star">*</span></label>
                        <label class="file-upload-label" for="declaraciones_firmadas">
                            <i class="bi bi-cloud-upload-fill d-block"></i>
                            <span>Haz clic para cargar las declaraciones firmadas</span>
                            <small class="d-block text-muted mt-2">Puedes seleccionar múltiples archivos PDF (Máx. 10MB por archivo)</small>
                        </label>
                        <input type="file" class="form-control d-none" name="declaraciones_firmadas[]" id="declaraciones_firmadas" accept=".pdf" multiple required>
                        <div id="filename_decl" class="mt-2"></div>
                    </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                    <button type="button" class="btn btn-custom-secondary" id="btnPrevious" style="display: none;">
                        <i class="bi bi-arrow-left"></i> Anterior
                    </button>
                    <button type="button" class="btn btn-custom-primary ms-auto" id="btnNext">
                        Siguiente <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-custom-primary ms-auto" id="btnSubmit" style="display: none;">
                        <i class="bi bi-check-circle-fill"></i> Completar Inscripción
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/inscripcion.js"></script>
</body>
</html>