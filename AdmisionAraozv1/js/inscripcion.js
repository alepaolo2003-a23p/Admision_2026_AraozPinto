// js/inscripcion.js
let currentStep = 1;
const totalSteps = 5;
let esMenorEdad = false;

// Actualizar preview de datos en tiempo real
document.getElementById('nombres').addEventListener('input', actualizarPreview);
document.getElementById('apellidos').addEventListener('input', actualizarPreview);
document.getElementById('dni').addEventListener('input', actualizarPreview);
document.getElementById('fecha_nacimiento').addEventListener('change', actualizarPreview);

function actualizarPreview() {
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    
    document.getElementById('nombre_preview').textContent = 
        (nombres + ' ' + apellidos).trim() || '-';
    document.getElementById('dni_preview').textContent = dni || '-';
}

// Calcular edad
document.getElementById('fecha_nacimiento').addEventListener('change', function() {
    const fechaNac = new Date(this.value);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNac.getFullYear();
    const mes = hoy.getMonth() - fechaNac.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
        edad--;
    }

    esMenorEdad = edad < 18;
    const badgeClass = esMenorEdad ? 'menor' : 'mayor';
    const edadText = esMenorEdad ? 'Menor de edad' : 'Mayor de edad';
    
    document.getElementById('edadDisplay').innerHTML = `
        <span class="edad-badge ${badgeClass}">
            <i class="bi bi-person-fill"></i> Edad: ${edad} años (${edadText})
        </span>
    `;
    
    document.getElementById('edad_preview').textContent = `${edad} años (${edadText})`;
});

// Botón para firmar declaraciones
document.getElementById('btnFirmarDeclaraciones').addEventListener('click', function() {
    // Validar que se hayan completado los datos básicos
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    const fechaNac = document.getElementById('fecha_nacimiento').value;
    const direccion = document.getElementById('direccion_firma').value;
    
    if (!nombres || !apellidos || !dni || !fechaNac) {
        showAlert('Por favor completa todos los campos del Paso 1 antes de firmar las declaraciones', 'warning');
        return;
    }
    
    if (!direccion) {
        showAlert('Por favor ingresa tu dirección antes de continuar', 'warning');
        return;
    }
    
    // Guardar dirección en el campo del paso 1
    document.getElementById('direccion').value = direccion;
    
    // Construir URL con parámetros
    const baseUrl = window.location.origin + window.location.pathname.replace('inscripcion.php', 'firmar_declaraciones.php');
    const params = new URLSearchParams({
        nombres: nombres,
        apellidos: apellidos,
        dni: dni,
        fecha_nacimiento: fechaNac,
        direccion: direccion
    });
    
    const url = `${baseUrl}?${params.toString()}`;
    
    // Abrir en nueva pestaña
    window.open(url, '_blank');
    
    // Mostrar mensaje informativo
    showAlert('Se ha abierto una nueva pestaña para firmar las declaraciones. Una vez completado, descarga el PDF y súbelo en el campo de abajo.', 'info');
});

// Validar que las carreras no sean iguales
document.getElementById('programa_segunda').addEventListener('change', function() {
    const primera = document.getElementById('programa_primera').value;
    const segunda = this.value;
    
    if (primera && segunda && primera === segunda) {
        showAlert('Las dos opciones de carrera no pueden ser iguales', 'warning');
        this.value = '';
    }
});

// File upload feedback
document.getElementById('documento_dni').addEventListener('change', function() {
    const fileName = this.files[0]?.name || '';
    if (fileName) {
        document.getElementById('filename_dni').innerHTML = `
            <i class="bi bi-check-circle-fill text-success"></i> Archivo seleccionado: <strong>${fileName}</strong>
        `;
    }
});

document.getElementById('certificados').addEventListener('change', function() {
    const fileName = this.files[0]?.name || '';
    if (fileName) {
        document.getElementById('filename_cert').innerHTML = `
            <i class="bi bi-check-circle-fill text-success"></i> Archivo seleccionado: <strong>${fileName}</strong>
        `;
    }
});

// Manejo especial para múltiples archivos de declaraciones
document.getElementById('declaraciones_firmadas').addEventListener('change', function() {
    const files = this.files;
    const displayDiv = document.getElementById('filename_decl');
    
    if (files.length > 0) {
        let html = '<div class="alert alert-success p-2">';
        html += `<strong><i class="bi bi-check-circle-fill"></i> ${files.length} archivo(s) seleccionado(s):</strong><ul class="mb-0 mt-2">`;
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            html += `<li><strong>${file.name}</strong> (${sizeInMB} MB)</li>`;
        }
        
        html += '</ul></div>';
        displayDiv.innerHTML = html;
    } else {
        displayDiv.innerHTML = '';
    }
});

function showAlert(message, type = 'danger') {
    const alertArea = document.getElementById('alertArea');
    const iconMap = {
        'danger': 'x-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle',
        'success': 'check-circle'
    };
    
    const alertHTML = `
        <div class="alert alert-${type} alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-${iconMap[type]}-fill"></i>
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    alertArea.innerHTML = alertHTML;
    alertArea.scrollIntoView({ behavior: 'smooth' });
    
    // Auto-cerrar después de 10 segundos (excepto errores)
    if (type !== 'danger') {
        setTimeout(() => {
            const alert = alertArea.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 10000);
    }
}

function validateStep(step) {
    const requiredFields = document.querySelectorAll(`#step-${step} [required]`);
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim() && field.type !== 'checkbox' && field.type !== 'file') {
            isValid = false;
            field.classList.add('is-invalid');
        } else if (field.type === 'checkbox' && !field.checked) {
            isValid = false;
            field.classList.add('is-invalid');
        } else if (field.type === 'file' && field.required && !field.files.length) {
            isValid = false;
            field.parentElement.classList.add('border-danger');
        } else {
            field.classList.remove('is-invalid');
            if (field.type === 'file') {
                field.parentElement.classList.remove('border-danger');
            }
        }
    });

    // Validaciones específicas por paso
    if (step === 1) {
        const dni = document.getElementById('dni').value;
        if (dni && dni.length !== 8) {
            showAlert('El DNI debe tener 8 dígitos', 'warning');
            return false;
        }
        
        const email = document.getElementById('email').value;
        if (email && !email.includes('@')) {
            showAlert('Email inválido', 'warning');
            return false;
        }

        if (!document.getElementById('fecha_nacimiento').value) {
            showAlert('La fecha de nacimiento es obligatoria', 'warning');
            return false;
        }
    }

    if (step === 3) {
        const primera = document.getElementById('programa_primera').value;
        const segunda = document.getElementById('programa_segunda').value;
        
        if (primera === segunda) {
            showAlert('Las dos opciones de carrera no pueden ser iguales', 'warning');
            return false;
        }

        if (!document.getElementById('acepta_terminos').checked) {
            showAlert('Debes aceptar los términos y condiciones', 'warning');
            return false;
        }
    }

    if (step === 5) {
        const direccion = document.getElementById('direccion_firma').value;
        if (!direccion) {
            showAlert('Por favor ingresa tu dirección antes de continuar', 'warning');
            return false;
        }
        
        // Copiar dirección al campo del formulario principal
        document.getElementById('direccion').value = direccion;
        
        // Validar que se haya subido el archivo de declaraciones
        const declaracionesFile = document.getElementById('declaraciones_firmadas');
        if (!declaracionesFile.files.length) {
            showAlert('Por favor sube el archivo PDF de las declaraciones firmadas', 'warning');
            return false;
        }
    }

    if (!isValid) {
        showAlert('Por favor completa todos los campos requeridos', 'warning');
        return false;
    }

    return true;
}

function updateProgress() {
    for (let i = 1; i <= totalSteps; i++) {
        const progressStep = document.getElementById(`progress-${i}`);
        
        if (i < currentStep) {
            progressStep.classList.add('completed');
            progressStep.classList.remove('active');
        } else if (i === currentStep) {
            progressStep.classList.add('active');
            progressStep.classList.remove('completed');
        } else {
            progressStep.classList.remove('active', 'completed');
        }
    }
}

function showStep(step) {
    document.querySelectorAll('.step-content').forEach(content => {
        content.classList.remove('active');
    });
    
    document.getElementById(`step-${step}`).classList.add('active');
    
    // Actualizar botones
    document.getElementById('btnPrevious').style.display = step === 1 ? 'none' : 'block';
    document.getElementById('btnNext').style.display = step === totalSteps ? 'none' : 'block';
    document.getElementById('btnSubmit').style.display = step === totalSteps ? 'block' : 'none';
    
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.getElementById('btnNext').addEventListener('click', function() {
    if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
    }
});

document.getElementById('btnPrevious').addEventListener('click', function() {
    currentStep--;
    showStep(currentStep);
});

document.getElementById('inscripcionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateStep(currentStep)) {
        return false;
    }

    // Mostrar loading
    const btnSubmit = document.getElementById('btnSubmit');
    const originalText = btnSubmit.innerHTML;
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

    // Enviar formulario
    const formData = new FormData(this);
    
    fetch('procesar_inscripcion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'confirmacion.php?codigo=' + data.codigo_inscripcion;
        } else {
            showAlert(data.message || 'Error al procesar la inscripción', 'danger');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error de conexión. Por favor intenta nuevamente.', 'danger');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = originalText;
    });
});

// Inicializar
showStep(1);

// Prevenir cierre accidental
window.addEventListener('beforeunload', function(e) {
    if (currentStep > 1) {
        e.preventDefault();
        e.returnValue = '¿Estás seguro de que deseas salir? Se perderán los datos ingresados.';
    }
});