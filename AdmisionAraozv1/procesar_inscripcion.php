<?php
// procesar_inscripcion.php
session_start();
header('Content-Type: application/json');

// Configuración de la base de datos
require_once 'config/database.php';

// Función para generar código único
function generarCodigoInscripcion($db) {
    do {
        $codigo = 'MRAP-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $stmt = $db->prepare("SELECT id FROM inscripciones_examen WHERE codigo_inscripcion = ?");
        $stmt->execute([$codigo]);
    } while ($stmt->rowCount() > 0);
    
    return $codigo;
}

// Función para subir archivos
function subirArchivo($file, $tipo, $postulante_id) {
    $uploadDir = "uploads/{$tipo}/";
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nombreArchivo = $postulante_id . '_' . $tipo . '_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
    $rutaDestino = $uploadDir . $nombreArchivo;
    
    // Validar tamaño (10MB máximo)
    if ($file['size'] > 10 * 1024 * 1024) {
        return [
            'success' => false,
            'error' => 'El archivo excede el tamaño máximo permitido (10MB)'
        ];
    }
    
    if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
        return [
            'success' => true,
            'nombre' => $nombreArchivo,
            'ruta' => $rutaDestino
        ];
    }
    
    return ['success' => false, 'error' => 'Error al mover el archivo'];
}

try {
    $db = conectarDB();
    $db->beginTransaction();
    
    // Validar datos requeridos
    $campos_requeridos = ['nombres', 'apellidos', 'dni', 'email', 'fecha_nacimiento', 
                         'colegio_procedencia', 'grado_actual', 'programa_primera', 
                         'turno_primera', 'programa_segunda', 'turno_segunda',
                         'nombre_apoderado', 'dni_apoderado', 'parentesco'];
    
    foreach ($campos_requeridos as $campo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            throw new Exception("El campo {$campo} es requerido");
        }
    }
    
    // Calcular edad
    $fecha_nac = new DateTime($_POST['fecha_nacimiento']);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nac)->y;
    $es_menor = $edad < 18;
    
    // Validar que las carreras sean diferentes
    if ($_POST['programa_primera'] == $_POST['programa_segunda']) {
        throw new Exception("Las dos opciones de carrera no pueden ser iguales");
    }
    
    // Verificar si el DNI ya existe
    $stmt = $db->prepare("SELECT id FROM postulantes WHERE dni = ?");
    $stmt->execute([$_POST['dni']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception("El DNI ya está registrado en el sistema");
    }
    
    // Verificar si el email ya existe
    $stmt = $db->prepare("SELECT id FROM postulantes WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception("El email ya está registrado en el sistema");
    }
    
    // Insertar postulante
    $sql = "INSERT INTO postulantes (nombres, apellidos, dni, email, telefono, fecha_nacimiento, 
            edad, es_menor_edad, direccion, estado_inscripcion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pendiente')";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['nombres'],
        $_POST['apellidos'],
        $_POST['dni'],
        $_POST['email'],
        $_POST['telefono'] ?? null,
        $_POST['fecha_nacimiento'],
        $edad,
        $es_menor ? 1 : 0,
        $_POST['direccion'] ?? null
    ]);
    
    $postulante_id = $db->lastInsertId();
    
    // Insertar información académica
    $sql = "INSERT INTO informacion_academica (postulante_id, colegio_procedencia, grado_actual, promedio_ultimo) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $postulante_id,
        $_POST['colegio_procedencia'],
        $_POST['grado_actual'],
        $_POST['promedio_ultimo'] ?? null
    ]);
    
    // Insertar apoderado
    $sql = "INSERT INTO apoderados (postulante_id, nombre_completo, dni_apoderado, parentesco, telefono) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $postulante_id,
        $_POST['nombre_apoderado'],
        $_POST['dni_apoderado'],
        $_POST['parentesco'],
        $_POST['telefono_apoderado'] ?? null
    ]);
    
    // Insertar opciones de carrera
    $sql = "INSERT INTO opciones_carrera (postulante_id, programa_id, turno, orden_preferencia) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    
    // Primera opción
    $stmt->execute([
        $postulante_id,
        $_POST['programa_primera'],
        $_POST['turno_primera'],
        'primera'
    ]);
    
    // Segunda opción
    $stmt->execute([
        $postulante_id,
        $_POST['programa_segunda'],
        $_POST['turno_segunda'],
        'segunda'
    ]);
    
    // Subir documentos individuales (DNI y Certificados)
    $documentos = [
        'documento_dni' => 'dni',
        'certificados' => 'certificados'
    ];
    
    foreach ($documentos as $input_name => $tipo) {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === UPLOAD_ERR_OK) {
            $resultado = subirArchivo($_FILES[$input_name], $tipo, $postulante_id);
            
            if ($resultado['success']) {
                $sql = "INSERT INTO documentos (postulante_id, tipo_documento, nombre_archivo, ruta_archivo) 
                        VALUES (?, ?, ?, ?)";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    $postulante_id,
                    $tipo,
                    $resultado['nombre'],
                    $resultado['ruta']
                ]);
            }
        }
    }
    
    // Subir múltiples archivos de declaraciones juradas
    if (isset($_FILES['declaraciones_firmadas']) && is_array($_FILES['declaraciones_firmadas']['name'])) {
        $total_files = count($_FILES['declaraciones_firmadas']['name']);
        
        for ($i = 0; $i < $total_files; $i++) {
            // Verificar si el archivo se subió correctamente
            if ($_FILES['declaraciones_firmadas']['error'][$i] === UPLOAD_ERR_OK) {
                // Crear array temporal para cada archivo
                $file_temp = [
                    'name' => $_FILES['declaraciones_firmadas']['name'][$i],
                    'type' => $_FILES['declaraciones_firmadas']['type'][$i],
                    'tmp_name' => $_FILES['declaraciones_firmadas']['tmp_name'][$i],
                    'error' => $_FILES['declaraciones_firmadas']['error'][$i],
                    'size' => $_FILES['declaraciones_firmadas']['size'][$i]
                ];
                
                $resultado = subirArchivo($file_temp, 'declaracion_jurada', $postulante_id);
                
                if ($resultado['success']) {
                    $sql = "INSERT INTO documentos (postulante_id, tipo_documento, nombre_archivo, ruta_archivo) 
                            VALUES (?, ?, ?, ?)";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        $postulante_id,
                        'declaracion_jurada',
                        $resultado['nombre'],
                        $resultado['ruta']
                    ]);
                }
            }
        }
    }
    
    // Insertar declaraciones juradas
    $declaraciones = $es_menor ? 
        ['menor_edad', 'no_devolucion', 'salud'] : 
        ['mayor_edad', 'salud'];
    
    $sql = "INSERT INTO declaraciones_juradas (postulante_id, tipo_declaracion, aceptado, fecha_aceptacion, ip_aceptacion) 
            VALUES (?, ?, 1, NOW(), ?)";
    
    $stmt = $db->prepare($sql);
    foreach ($declaraciones as $tipo) {
        $stmt->execute([
            $postulante_id,
            $tipo,
            $_SERVER['REMOTE_ADDR']
        ]);
    }
    
    // Crear examen de admisión (obtener el próximo examen disponible)
    $stmt = $db->query("SELECT id FROM examenes_admision WHERE estado = 'programado' AND fecha_examen > NOW() ORDER BY fecha_examen LIMIT 1");
    $examen = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$examen) {
        // Si no hay examen programado, crear uno por defecto
        $sql = "INSERT INTO examenes_admision (codigo_examen, fecha_examen, hora_inicio, duracion_minutos) 
                VALUES (?, DATE_ADD(NOW(), INTERVAL 30 DAY), '09:00:00', 120)";
        
        $codigo_examen = 'EX-' . date('Y') . '-' . rand(100, 999);
        $stmt = $db->prepare($sql);
        $stmt->execute([$codigo_examen]);
        $examen_id = $db->lastInsertId();
    } else {
        $examen_id = $examen['id'];
    }
    
    // Crear inscripción al examen
    $codigo_inscripcion = generarCodigoInscripcion($db);
    
    $sql = "INSERT INTO inscripciones_examen (postulante_id, examen_id, codigo_inscripcion, pago_realizado, monto_pagado) 
            VALUES (?, ?, ?, 0, 150.00)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $postulante_id,
        $examen_id,
        $codigo_inscripcion
    ]);
    
    // Registrar en logs
    $sql = "INSERT INTO logs_sistema (accion, descripcion, ip_address, user_agent) 
            VALUES ('inscripcion_nueva', ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([
        "Nueva inscripción: {$_POST['nombres']} {$_POST['apellidos']} (DNI: {$_POST['dni']})",
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ]);
    
    $db->commit();
    
    // Enviar email de confirmación (opcional)
    // enviarEmailConfirmacion($_POST['email'], $_POST['nombres'], $codigo_inscripcion);
    
    echo json_encode([
        'success' => true,
        'message' => 'Inscripción completada exitosamente',
        'codigo_inscripcion' => $codigo_inscripcion,
        'postulante_id' => $postulante_id
    ]);
    
} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

function enviarEmailConfirmacion($email, $nombre, $codigo) {
    // Implementar envío de email aquí
    // Por ahora solo un placeholder
    
    $asunto = "Confirmación de Inscripción - IESTP María Rosario Araoz Pinto";
    $mensaje = "
    <html>
    <body>
        <h2>¡Felicitaciones {$nombre}!</h2>
        <p>Tu inscripción ha sido registrada exitosamente.</p>
        <p><strong>Código de inscripción:</strong> {$codigo}</p>
        <p>Por favor, realiza el pago de S/. 150.00 para completar tu inscripción.</p>
        <p>Recuerda presentarte el día del examen con tu DNI y este código.</p>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: admision@mrap.edu.pe" . "\r\n";
    
    // mail($email, $asunto, $mensaje, $headers);
}
?>