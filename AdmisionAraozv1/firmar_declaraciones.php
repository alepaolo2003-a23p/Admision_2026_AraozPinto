<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firmar Declaraciones Juradas - IESTP MRAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        :root {
            --primary-green: #006b3f;
            --dark-green: #004d2e;
            --light-green: #e8f5e9;
            --orange: #ff8c42;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px 0;
        }

        .container {
            max-width: 900px;
        }

        .header-card {
            background: white;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }

        .header-card h1 {
            color: var(--primary-green);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .declaracion-card {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }

        .declaracion-content {
            background: #f9f9f9;
            padding: 25px;
            border-left: 4px solid var(--primary-green);
            margin-bottom: 25px;
            max-height: 400px;
            overflow-y: auto;
            font-size: 0.9rem;
            line-height: 1.8;
            white-space: pre-line;
        }

        .firma-section {
            background: #fff9e6;
            padding: 25px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-primary-green {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-green:hover {
            background: var(--dark-green);
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 15px;
        }

        .declaracion-title {
            color: var(--primary-green);
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-green);
        }

        .firma-preview {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 8px;
        }

        .firma-preview.show {
            display: block;
        }

        .input-firma {
            font-family: 'Brush Script MT', cursive;
            font-size: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    // Obtener parámetros de la URL
    $nombres = $_GET['nombres'] ?? '';
    $apellidos = $_GET['apellidos'] ?? '';
    $dni = $_GET['dni'] ?? '';
    $fecha_nacimiento = $_GET['fecha_nacimiento'] ?? '';
    $direccion = $_GET['direccion'] ?? '';
    
    // Calcular edad
    $edad = 0;
    $es_menor = false;
    if ($fecha_nacimiento) {
        $fecha_nac_obj = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_nac_obj)->y;
        $es_menor = $edad < 18;
    }
    ?>
    <div class="container">
        <div class="header-card">
            <h1><i class="bi bi-pen-fill"></i> Firmar Declaraciones Juradas</h1>
            <p class="text-muted mb-0">Complete y firme digitalmente sus declaraciones juradas</p>
        </div>

        <div id="alertArea"></div>

        <!-- Formulario de datos -->
        <div class="declaracion-card">
            <h4 class="declaracion-title">Datos del Firmante</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombres <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombres" value="<?php echo htmlspecialchars($nombres); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">DNI <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="dni" maxlength="8" pattern="[0-9]{8}" value="<?php echo htmlspecialchars($dni); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Fecha de Nacimiento <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento); ?>" required>
                    <small id="edadInfo" class="text-muted">
                        <?php if ($edad > 0): ?>
                        <span class="badge <?php echo $es_menor ? 'bg-warning text-dark' : 'bg-success'; ?>">
                            <?php echo $edad; ?> años (<?php echo $es_menor ? 'Menor' : 'Mayor'; ?> de edad)
                        </span>
                        <?php endif; ?>
                    </small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label fw-bold">Dirección <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="direccion" rows="2" required><?php echo htmlspecialchars($direccion); ?></textarea>
                </div>
            </div>
        </div>

        <!-- Declaración Mayor de Edad -->
        <div class="declaracion-card" id="declaracionMayor" style="display: none;">
            <h4 class="declaracion-title">Declaración Jurada - Mayor de Edad</h4>
            <div class="declaracion-content" id="contenidoMayor"></div>
            
            <div class="firma-section">
                <h5 class="mb-3"><i class="bi bi-pencil-square"></i> Firma Digital</h5>
                <p class="text-muted mb-3">Escriba su nombre completo para generar su firma digital:</p>
                <input type="text" class="form-control input-firma mb-3" id="firmaMayor" placeholder="Nombre Completo" readonly>
                <div class="firma-preview" id="previewMayor">
                    <strong>Vista previa de firma:</strong>
                    <div class="text-center mt-2" style="font-family: 'Brush Script MT', cursive; font-size: 2.5rem; color: #000;">
                        <span id="firmaTextMayor"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Declaración Menor de Edad -->
        <div class="declaracion-card" id="declaracionMenor" style="display: none;">
            <h4 class="declaracion-title">Declaración Jurada - Menor de Edad</h4>
            <div class="alert alert-warning">
                <i class="bi bi-info-circle-fill"></i> Esta declaración debe ser firmada por el padre, madre o apoderado.
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre del Apoderado <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nombreApoderado">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">DNI del Apoderado <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="dniApoderado" maxlength="8" pattern="[0-9]{8}">
            </div>
            <div class="declaracion-content" id="contenidoMenor"></div>
            
            <div class="firma-section">
                <h5 class="mb-3"><i class="bi bi-pencil-square"></i> Firma Digital del Apoderado</h5>
                <input type="text" class="form-control input-firma mb-3" id="firmaMenor" placeholder="Nombre del Apoderado" readonly>
                <div class="firma-preview" id="previewMenor">
                    <strong>Vista previa de firma:</strong>
                    <div class="text-center mt-2" style="font-family: 'Brush Script MT', cursive; font-size: 2.5rem; color: #000;">
                        <span id="firmaTextMenor"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Declaración de No Devolución (solo menores) -->
        <div class="declaracion-card" id="declaracionNoDevolucion" style="display: none;">
            <h4 class="declaracion-title">Declaración de No Devolución</h4>
            <div class="declaracion-content" id="contenidoNoDevolucion"></div>
            
            <div class="firma-section">
                <h5 class="mb-3"><i class="bi bi-pencil-square"></i> Firma Digital del Apoderado</h5>
                <input type="text" class="form-control input-firma mb-3" id="firmaNoDevolucion" placeholder="Nombre del Apoderado" readonly>
                <div class="firma-preview" id="previewNoDevolucion">
                    <strong>Vista previa de firma:</strong>
                    <div class="text-center mt-2" style="font-family: 'Brush Script MT', cursive; font-size: 2.5rem; color: #000;">
                        <span id="firmaTextNoDevolucion"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Declaración de Salud -->
        <div class="declaracion-card" id="declaracionSalud" style="display: none;">
            <h4 class="declaracion-title">Declaración Jurada de Salud</h4>
            <div class="declaracion-content" id="contenidoSalud"></div>
            
            <div class="firma-section">
                <h5 class="mb-3"><i class="bi bi-pencil-square"></i> Firma Digital</h5>
                <input type="text" class="form-control input-firma mb-3" id="firmaSalud" placeholder="Nombre Completo" readonly>
                <div class="firma-preview" id="previewSalud">
                    <strong>Vista previa de firma:</strong>
                    <div class="text-center mt-2" style="font-family: 'Brush Script MT', cursive; font-size: 2.5rem; color: #000;">
                        <span id="firmaTextSalud"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="declaracion-card">
            <div class="d-flex justify-content-between">
                <button class="btn btn-secondary-custom" onclick="window.close()">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
                <button class="btn btn-primary-green" onclick="generarPDFs()">
                    <i class="bi bi-file-pdf-fill"></i> Generar y Descargar PDFs
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/firmar_declaraciones.js"></script>
</body>
</html>