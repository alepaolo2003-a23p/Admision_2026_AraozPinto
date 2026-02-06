<?php
// confirmacion.php
require_once 'config/database.php';

$codigo_inscripcion = $_GET['codigo'] ?? '';

if (empty($codigo_inscripcion)) {
    header('Location: index.php');
    exit;
}

try {
    $db = conectarDB();
    
    $sql = "SELECT 
                i.codigo_inscripcion,
                i.fecha_inscripcion,
                i.monto_pagado,
                p.nombres,
                p.apellidos,
                p.dni,
                p.email,
                p.telefono,
                prog1.nombre as programa_primera,
                oc1.turno as turno_primera,
                prog2.nombre as programa_segunda,
                oc2.turno as turno_segunda,
                e.fecha_examen,
                e.hora_inicio,
                e.aula
            FROM inscripciones_examen i
            INNER JOIN postulantes p ON i.postulante_id = p.id
            LEFT JOIN opciones_carrera oc1 ON p.id = oc1.postulante_id AND oc1.orden_preferencia = 'primera'
            LEFT JOIN programas_estudio prog1 ON oc1.programa_id = prog1.id
            LEFT JOIN opciones_carrera oc2 ON p.id = oc2.postulante_id AND oc2.orden_preferencia = 'segunda'
            LEFT JOIN programas_estudio prog2 ON oc2.programa_id = prog2.id
            LEFT JOIN examenes_admision e ON i.examen_id = e.id
            WHERE i.codigo_inscripcion = ?";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$codigo_inscripcion]);
    $inscripcion = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$inscripcion) {
        throw new Exception("Inscripción no encontrada");
    }
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Inscripción - IESTP MRAP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            padding: 40px 0;
        }
        
        .confirmation-card {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .header-success i {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: checkmark 0.5s ease-in-out;
        }
        
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .content-section {
            padding: 30px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #666;
        }
        
        .info-value {
            font-weight: 500;
            color: #1e40af;
        }
        
        .codigo-box {
            background: #f0f9ff;
            border: 2px dashed #1e40af;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }
        
        .codigo-box h3 {
            color: #1e40af;
            font-weight: bold;
            font-size: 2rem;
            margin: 0;
        }
        
        .alert-payment {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        
        .btn-print {
            background: #1e40af;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-print:hover {
            background: #1e3a8a;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card">
            <div class="header-success">
                <i class="bi bi-check-circle-fill"></i>
                <h1>¡Inscripción Exitosa!</h1>
                <p class="mb-0">Tu inscripción ha sido registrada correctamente</p>
            </div>
            
            <div class="content-section">
                <div class="codigo-box">
                    <small class="text-muted">Tu código de inscripción es:</small>
                    <h3><?php echo htmlspecialchars($inscripcion['codigo_inscripcion']); ?></h3>
                    <small class="text-muted">Guarda este código para futuros trámites</small>
                </div>
                
                <h5 class="text-dark mb-3"><i class="bi bi-person-fill"></i> Datos del Postulante</h5>
                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Nombres y Apellidos:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['nombres'] . ' ' . $inscripcion['apellidos']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">DNI:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['dni']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['email']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['telefono'] ?: 'No registrado'); ?></span>
                    </div>
                </div>
                
                <h5 class="text-dark mb-3"><i class="bi bi-clipboard-check-fill"></i> Programas Seleccionados</h5>
                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Primera Opción:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['programa_primera'] . ' - Turno ' . ucfirst($inscripcion['turno_primera'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Segunda Opción:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['programa_segunda'] . ' - Turno ' . ucfirst($inscripcion['turno_segunda'])); ?></span>
                    </div>
                </div>
                
                <?php if ($inscripcion['fecha_examen']): ?>
                <h5 class="text-dark mb-3"><i class="bi bi-calendar-event-fill"></i> Información del Examen</h5>
                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Fecha del Examen:</span>
                        <span class="info-value"><?php echo date('d/m/Y', strtotime($inscripcion['fecha_examen'])); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hora:</span>
                        <span class="info-value"><?php echo date('H:i', strtotime($inscripcion['hora_inicio'])); ?></span>
                    </div>
                    <?php if ($inscripcion['aula']): ?>
                    <div class="info-row">
                        <span class="info-label">Aula:</span>
                        <span class="info-value"><?php echo htmlspecialchars($inscripcion['aula']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="alert-payment">
                    <h5 class="mb-3"><i class="bi bi-exclamation-triangle-fill"></i> Importante - Pago de Inscripción</h5>
                    <p><strong>Monto a pagar:</strong> S/. <?php echo number_format($inscripcion['monto_pagado'], 2); ?></p>
                    <p class="mb-0"><small>Realiza el pago en las oficinas del instituto o mediante transferencia bancaria. No olvides presentar tu código de inscripción.</small></p>
                </div>
                
                <div class="alert alert-info">
                    <h6><i class="bi bi-info-circle-fill"></i> Próximos pasos:</h6>
                    <ol class="mb-0">
                        <li>Imprime esta constancia de inscripción</li>
                        <li>Realiza el pago de S/. 150.00 en las oficinas del instituto</li>
                        <li>Presenta tu DNI el día del examen</li>
                        <li>Llega 30 minutos antes de la hora del examen</li>
                    </ol>
                </div>
                
                <div class="text-center mt-4">
                    <button onclick="window.print()" class="btn btn-print me-2">
                        <i class="bi bi-printer-fill"></i> Imprimir Constancia
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-house-fill"></i> Volver al Inicio
                    </a>
                </div>
                
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Fecha de inscripción: <?php echo date('d/m/Y H:i', strtotime($inscripcion['fecha_inscripcion'])); ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>