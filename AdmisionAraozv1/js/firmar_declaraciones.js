// js/firmar_declaraciones.js
let esMenorEdad = false;
let datosPostulante = {};

// Plantillas de declaraciones
const plantillas = {
    mayor: `DECLARACIÓN JURADA DE DOCUMENTOS
(POSTULANTE MAYOR DE EDAD)

El Instituto de Educación Superior Tecnológico Público María Rosario Araoz Pinto establece la siguiente declaración jurada en el marco de la LEY N.° 30512 DE INSTITUTOS Y ESCUELAS DE EDUCACIÓN SUPERIOR Y DE LA CARRERA PÚBLICA DE SUS DOCENTES y el artículo 411° del Código Penal.

Yo, [NOMBRES_APELLIDOS] con DNI N.° [DNI], domiciliado(a) en [DIRECCION]

DECLARO BAJO JURAMENTO QUE:

I. Al estar consciente del pago realizado por el derecho de examen de admisión y prospecto, tengo conocimiento de la NO DEVOLUCIÓN del depósito realizado, acepto no realizar el pedido de la devolución del mismo, por cualquier motivo.

II. Mis datos personales consignados en la presente declaración jurada y en la inscripción vía web de la IESTP María Rosario Araoz Pinto son los mismos que figuran en los documentos de identidad (DNI, pasaporte o carné de extranjería).

III. Los documentos proporcionados virtualmente en la inscripción son fidedignos a los originales y no tienen ninguna modificación o alteración.

IV. He culminado satisfactoriamente mis estudios de nivel secundaria en la Institución Educativa indicada.

Autorizo al IESTP María Rosario Araoz Pinto la verificación de la presente DECLARACIÓN JURADA, asumiendo la responsabilidad civil y/o penal de comprobarse la falsedad de la información registrada al momento de mi inscripción.

De faltar a la verdad en esta declaración me sujeto a los alcances de lo establecido en el artículo 411° del Código Penal y acepto la anulación del examen de admisión del IESTP María Rosario Araoz Pinto, sin lugar a reclamo.`,

    menor: `DECLARACIÓN JURADA DE DOCUMENTOS
(POSTULANTE MENOR DE EDAD)

El Instituto de Educación Superior Tecnológico Público María Rosario Araoz Pinto establece la siguiente declaración jurada en el marco de la LEY N.° 30512 DE INSTITUTOS Y ESCUELAS DE EDUCACIÓN SUPERIOR Y DE LA CARRERA PÚBLICA DE SUS DOCENTES y el artículo 411° del Código Penal.

Yo, [NOMBRE_APODERADO] PADRE, MADRE O APODERADO(A) de [NOMBRES_APELLIDOS] (postulante menor de edad), identificado(a) con DNI N.° [DNI_APODERADO], domiciliado(a) en [DIRECCION].

DECLARO BAJO JURAMENTO QUE:

I. Mis datos personales y los de mi hijo(a) o apoderante consignados en la presente declaración jurada y en la inscripción vía web de la IESTP María Rosario Araoz Pinto son los mismos que figuran en los documentos de identidad (DNI, pasaporte o carné de extranjería).

II. Los documentos proporcionados virtualmente en la inscripción son fidedignos a los originales y no tienen ninguna modificación o alteración.

III. Mi hijo(a) o apoderante ha culminado satisfactoriamente sus estudios de nivel secundaria.

IV. Al estar consciente del pago realizado por el derecho de examen de admisión y prospecto, tengo conocimiento de la NO DEVOLUCIÓN del depósito realizado, acepto no realizar el pedido de la devolución del mismo, por cualquier motivo.

Autorizo al IESTP María Rosario Araoz Pinto la verificación de la presente DECLARACIÓN JURADA, asumiendo la responsabilidad civil y/o penal de comprobarse la falsedad de la información registrada.`,

    noDevolucion: `DECLARACIÓN JURADA DE NO DEVOLUCIÓN DE DINERO
(POSTULANTE MENOR DE EDAD)

Yo, [NOMBRE_APODERADO] PADRE, MADRE O APODERADO(A), identificado(a) con DNI N.° [DNI_APODERADO], en calidad de responsable legal del postulante menor de edad [NOMBRES_APELLIDOS], declaro bajo juramento haber recibido información clara y precisa sobre la política de NO DEVOLUCIÓN DE DINERO en caso el postulante decida no continuar sus estudios en la institución o no apruebe el examen de admisión.

RECONOZCO QUE:

1. El depósito realizado para el examen de admisión y prospecto (S/. 150.00) es de carácter no reembolsable.

2. Cualquier circunstancia que impida la participación del postulante en el proceso de admisión no justifica la devolución del monto pagado.

3. Una vez realizado el depósito, no se aceptarán solicitudes de devolución, independientemente de la razón invocada.

4. He sido informado(a) de esta política antes de realizar el pago y acepto sus términos sin lugar a reclamo posterior.

En señal de conformidad y con plena conciencia de lo manifestado, firmo la presente declaración jurada.`,

    salud: `DECLARACIÓN JURADA DE SALUD
(DE NO PADECER ENFERMEDADES CONTAGIOSAS)

Yo, [NOMBRES_APELLIDOS] identificado(a) con DNI N.° [DNI], domiciliado(a) en [DIRECCION], en condición de postulante del proceso de admisión 2026 al Instituto de Educación Superior Tecnológico Público María Rosario Araoz Pinto, declaro bajo juramento que:

1. A la fecha NO PADEZCO de enfermedades contagiosas que representen un riesgo para la salud pública.

2. NO presento síntomas de enfermedad como fiebre, cansancio, tos, dificultad para respirar, dolor de garganta, o cualquier otra manifestación de enfermedad transmisible.

3. NO he estado expuesto(a) a personas diagnosticadas con enfermedades contagiosas en las últimas dos semanas.

4. NO me encuentro dentro de grupos de riesgo que puedan verse afectados por enfermedades infecciosas.

5. No poseo ninguna condición médica que pueda poner en riesgo mi salud o la de los demás en el ambiente académico.

6. Estoy en condiciones óptimas de salud para participar en el proceso de admisión y posteriormente continuar con mis estudios en la institución.

En caso de resultar FALSA la información que proporciono, me someto a las responsabilidades administrativas, civiles y penales que correspondan conforme a las disposiciones normativas vigentes.

Declaración realizada bajo la responsabilidad penal del Código Penal Peruano.`
};

// Calcular edad cuando cambie la fecha
document.getElementById('fecha_nacimiento').addEventListener('change', function() {
    const fechaNac = new Date(this.value);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNac.getFullYear();
    const mes = hoy.getMonth() - fechaNac.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
        edad--;
    }

    esMenorEdad = edad < 18;
    
    document.getElementById('edadInfo').innerHTML = `
        <span class="badge ${esMenorEdad ? 'bg-warning text-dark' : 'bg-success'}">
            ${edad} años (${esMenorEdad ? 'Menor' : 'Mayor'} de edad)
        </span>
    `;

    actualizarDeclaraciones();
});

// Actualizar nombre completo en campos de firma
['nombres', 'apellidos'].forEach(id => {
    document.getElementById(id).addEventListener('input', actualizarFirmas);
});

document.getElementById('nombreApoderado')?.addEventListener('input', actualizarFirmas);

function actualizarFirmas() {
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const nombreCompleto = `${nombres} ${apellidos}`.trim();
    const nombreApoderado = document.getElementById('nombreApoderado')?.value || '';

    if (nombreCompleto) {
        document.getElementById('firmaMayor').value = nombreCompleto;
        document.getElementById('firmaTextMayor').textContent = nombreCompleto;
        document.getElementById('previewMayor').classList.add('show');

        document.getElementById('firmaSalud').value = nombreCompleto;
        document.getElementById('firmaTextSalud').textContent = nombreCompleto;
        document.getElementById('previewSalud').classList.add('show');
    }

    if (nombreApoderado) {
        document.getElementById('firmaMenor').value = nombreApoderado;
        document.getElementById('firmaTextMenor').textContent = nombreApoderado;
        document.getElementById('previewMenor').classList.add('show');

        document.getElementById('firmaNoDevolucion').value = nombreApoderado;
        document.getElementById('firmaTextNoDevolucion').textContent = nombreApoderado;
        document.getElementById('previewNoDevolucion').classList.add('show');
    }
}

function actualizarDeclaraciones() {
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    const direccion = document.getElementById('direccion').value;
    const nombreCompleto = `${nombres} ${apellidos}`;

    // Ocultar todas
    document.getElementById('declaracionMayor').style.display = 'none';
    document.getElementById('declaracionMenor').style.display = 'none';
    document.getElementById('declaracionNoDevolucion').style.display = 'none';
    document.getElementById('declaracionSalud').style.display = 'none';

    if (esMenorEdad) {
        // Mostrar declaraciones para menores
        document.getElementById('declaracionMenor').style.display = 'block';
        document.getElementById('declaracionNoDevolucion').style.display = 'block';
        document.getElementById('declaracionSalud').style.display = 'block';

        const nombreApoderado = document.getElementById('nombreApoderado')?.value || '__________________';
        const dniApoderado = document.getElementById('dniApoderado')?.value || '__________________';

        document.getElementById('contenidoMenor').textContent = plantillas.menor
            .replace('[NOMBRES_APELLIDOS]', nombreCompleto || '__________________')
            .replace('[NOMBRE_APODERADO]', nombreApoderado)
            .replace('[DNI_APODERADO]', dniApoderado)
            .replace('[DIRECCION]', direccion || '__________________');

        document.getElementById('contenidoNoDevolucion').textContent = plantillas.noDevolucion
            .replace('[NOMBRES_APELLIDOS]', nombreCompleto || '__________________')
            .replace('[NOMBRE_APODERADO]', nombreApoderado)
            .replace('[DNI_APODERADO]', dniApoderado);
    } else {
        // Mostrar declaraciones para mayores
        document.getElementById('declaracionMayor').style.display = 'block';
        document.getElementById('declaracionSalud').style.display = 'block';

        document.getElementById('contenidoMayor').textContent = plantillas.mayor
            .replace('[NOMBRES_APELLIDOS]', nombreCompleto || '__________________')
            .replace('[DNI]', dni || '__________________')
            .replace('[DIRECCION]', direccion || '__________________');
    }

    document.getElementById('contenidoSalud').textContent = plantillas.salud
        .replace('[NOMBRES_APELLIDOS]', nombreCompleto || '__________________')
        .replace('[DNI]', dni || '__________________')
        .replace('[DIRECCION]', direccion || '__________________');
    
    actualizarFirmas();
}

async function generarPDFs() {
    if (!validarCampos()) {
        return;
    }

    const { jsPDF } = window.jspdf;
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    const fecha = new Date().toLocaleDateString('es-PE');

    try {
        if (esMenorEdad) {
            const nombreApoderado = document.getElementById('nombreApoderado').value;
            
            // PDF Menor de Edad
            generarPDF('Declaracion_Menor_Edad', document.getElementById('contenidoMenor').textContent, nombreApoderado, fecha);
            
            // PDF No Devolución
            await esperar(500);
            generarPDF('Declaracion_No_Devolucion', document.getElementById('contenidoNoDevolucion').textContent, nombreApoderado, fecha);
        } else {
            // PDF Mayor de Edad
            generarPDF('Declaracion_Mayor_Edad', document.getElementById('contenidoMayor').textContent, `${nombres} ${apellidos}`, fecha);
        }

        // PDF Salud (para ambos)
        await esperar(500);
        generarPDF('Declaracion_Salud', document.getElementById('contenidoSalud').textContent, `${nombres} ${apellidos}`, fecha);

        showAlert('PDFs generados exitosamente. Descarga los archivos y súbelos en el formulario de inscripción.', 'success');
    } catch (error) {
        showAlert('Error al generar los PDFs: ' + error.message, 'danger');
    }
}

function generarPDF(nombreArchivo, contenido, firma, fecha) {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');
    
    // Configuración
    pdf.setFont('helvetica');
    pdf.setFontSize(11);
    
    // Contenido
    const lineas = pdf.splitTextToSize(contenido, 170);
    pdf.text(lineas, 20, 20);
    
    // Firma
    const yFirma = 20 + (lineas.length * 5) + 20;
    pdf.setFontSize(10);
    pdf.text('Firma:', 20, yFirma);
    pdf.setFont('helvetica', 'italic');
    pdf.setFontSize(16);
    pdf.text(firma, 45, yFirma);
    
    // Fecha
    pdf.setFont('helvetica', 'normal');
    pdf.setFontSize(10);
    pdf.text(`Lima, ${fecha}`, 20, yFirma + 10);
    
    // Línea de firma
    pdf.line(45, yFirma + 2, 120, yFirma + 2);
    
    // Descargar
    pdf.save(`${nombreArchivo}_${Date.now()}.pdf`);
}

function esperar(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function validarCampos() {
    const nombres = document.getElementById('nombres').value.trim();
    const apellidos = document.getElementById('apellidos').value.trim();
    const dni = document.getElementById('dni').value.trim();
    const fecha = document.getElementById('fecha_nacimiento').value;
    const direccion = document.getElementById('direccion').value.trim();

    if (!nombres || !apellidos || !dni || !fecha || !direccion) {
        showAlert('Por favor complete todos los campos obligatorios', 'warning');
        return false;
    }

    if (dni.length !== 8) {
        showAlert('El DNI debe tener 8 dígitos', 'warning');
        return false;
    }

    if (esMenorEdad) {
        const nombreApoderado = document.getElementById('nombreApoderado').value.trim();
        const dniApoderado = document.getElementById('dniApoderado').value.trim();
        
        if (!nombreApoderado || !dniApoderado) {
            showAlert('Por favor ingrese los datos completos del apoderado', 'warning');
            return false;
        }
        
        if (dniApoderado.length !== 8) {
            showAlert('El DNI del apoderado debe tener 8 dígitos', 'warning');
            return false;
        }
    }

    return true;
}

function showAlert(message, type) {
    const alertArea = document.getElementById('alertArea');
    const iconMap = {
        'success': 'check-circle',
        'warning': 'exclamation-triangle',
        'danger': 'x-circle',
        'info': 'info-circle'
    };
    
    const alertHTML = `
        <div class="alert alert-${type} alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-${iconMap[type]}-fill"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    alertArea.innerHTML = alertHTML;
    alertArea.scrollIntoView({ behavior: 'smooth' });
}

// Inicializar cuando se carga la página
window.addEventListener('DOMContentLoaded', function() {
    // Calcular edad inicial si hay fecha
    const fechaNac = document.getElementById('fecha_nacimiento').value;
    if (fechaNac) {
        document.getElementById('fecha_nacimiento').dispatchEvent(new Event('change'));
    }
    
    actualizarDeclaraciones();
});