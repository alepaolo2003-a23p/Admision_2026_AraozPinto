<?php
// descargar_declaracion.php

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

$contenidos = [
    'mayor' => "
DECLARACIÓN JURADA DE DOCUMENTOS
(POSTULANTE MAYOR DE EDAD)

El Instituto de Educación Superior Tecnológico Público María Rosario Araoz Pinto 
establece la siguiente declaración jurada en el marco de la LEY N.° 30512 DE 
INSTITUTOS Y ESCUELAS DE EDUCACIÓN SUPERIOR Y DE LA CARRERA PÚBLICA DE SUS 
DOCENTES y el artículo 411° del Código Penal.

Yo, _________________________ con DNI N.° _____________, 
domiciliado(a) en _______________________________________________

DECLARO BAJO JURAMENTO QUE:

I. Al estar consciente del pago realizado por el derecho de examen de admisión 
y prospecto, tengo conocimiento de la NO DEVOLUCIÓN del depósito realizado, 
acepto no realizar el pedido de la devolución del mismo, por cualquier motivo.

II. Mis datos personales consignados en la presente declaración jurada y en la 
inscripción vía web de la IESTP María Rosario Araoz Pinto son los mismos que 
figuran en los documentos de identidad (DNI, pasaporte o carné de extranjería).

III. Los documentos proporcionados virtualmente en la inscripción son fidedignos 
a los originales y no tienen ninguna modificación o alteración.

IV. He culminado satisfactoriamente mis estudios de nivel secundaria en la 
Institución Educativa _________________________________.

Autorizo al IESTP María Rosario Araoz Pinto la verificación de la presente 
DECLARACIÓN JURADA, asumiendo la responsabilidad civil y/o penal de 
comprobarse la falsedad de la información registrada al momento de mi inscripción. 
De faltar a la verdad en esta declaración me sujeto a los alcances de lo 
establecido en el artículo 411° del Código Penal y acepto la anulación del 
examen de admisión del IESTP María Rosario Araoz Pinto, sin lugar a reclamo.


Apellidos y Nombres: _______________________________________________

DNI o Carné de Extranjería: __________________________________________

Firma: _________________________    Huella Digital (Índice Derecho):


Lima, _____ de _________________ de 2026
",
    
    'menor' => "
DECLARACIÓN JURADA DE DOCUMENTOS
(POSTULANTE MENOR DE EDAD)

El Instituto de Educación Superior Tecnológico Público María Rosario Araoz Pinto 
establece la siguiente declaración jurada en el marco de la LEY N.° 30512 DE 
INSTITUTOS Y ESCUELAS DE EDUCACIÓN SUPERIOR Y DE LA CARRERA PÚBLICA DE SUS 
DOCENTES y el artículo 411° del Código Penal.

Yo, _________________________ PADRE, MADRE O APODERADO(A) de 
_________________________ (postulante menor de edad), identificado(a) con 
DNI N.° _____________, domiciliado(a) en ____________________________.

DECLARO BAJO JURAMENTO QUE:

I. Mis datos personales y los de mi hijo(a) o apoderante consignados en la 
presente declaración jurada y en la inscripción vía web de la IESTP María 
Rosario Araoz Pinto son los mismos que figuran en los documentos de identidad 
(DNI, pasaporte o carné de extranjería).

II. Los documentos proporcionados virtualmente en la inscripción son fidedignos 
a los originales y no tienen ninguna modificación o alteración.

III. Mi hijo(a) o apoderante ha culminado satisfactoriamente sus estudios de 
nivel secundaria en la Institución Educativa 
_________________________________ ubicada en la ciudad de ____________, 
provincia _____________, región _____________.

IV. Al estar consciente del pago realizado por el derecho de examen de admisión 
y prospecto, tengo conocimiento de la NO DEVOLUCIÓN del depósito realizado, 
acepto no realizar el pedido de la devolución del mismo, por cualquier motivo.

Autorizo al IESTP María Rosario Araoz Pinto la verificación de la presente 
DECLARACIÓN JURADA, asumiendo la responsabilidad civil y/o penal de 
comprobarse la falsedad de la información registrada. De faltar a la verdad 
en esta declaración me sujeto a los alcances de lo establecido en el artículo 
411° del Código Penal y acepto la anulación del examen de admisión, sin 
lugar a reclamo.


Apellidos y Nombres del Apoderado: __________________________________

DNI o Carné de Extranjería: __________________________________________

Firma: _________________________    Huella Digital (Índice Derecho):


Lima, _____ de _________________ de 2026
",
    
    'no_devolucion' => "
DECLARACIÓN JURADA DE NO DEVOLUCIÓN DE DINERO
(POSTULANTE MENOR DE EDAD)

Yo, _________________________ PADRE, MADRE O APODERADO(A), identificado(a) 
con DNI N.° _____________, en calidad de responsable legal del postulante 
menor de edad _________________________, declaro bajo juramento haber recibido 
información clara y precisa sobre la política de NO DEVOLUCIÓN DE DINERO en 
caso el postulante decida no continuar sus estudios en la institución o no 
apruebe el examen de admisión.

RECONOZCO QUE:

1. El depósito realizado para el examen de admisión y prospecto (S/. 150.00) 
   es de carácter no reembolsable.

2. Cualquier circunstancia que impida la participación del postulante en el 
   proceso de admisión no justifica la devolución del monto pagado.

3. Una vez realizado el depósito, no se aceptarán solicitudes de devolución, 
   independientemente de la razón invocada.

4. He sido informado(a) de esta política antes de realizar el pago y acepto 
   sus términos sin lugar a reclamo posterior.

En señal de conformidad y con plena conciencia de lo manifestado, firmo la 
presente declaración jurada.


Apellidos y Nombres del Apoderado: __________________________________

DNI o Carné de Extranjería: __________________________________________

Nombre del Postulante: ______________________________________________

DNI del Postulante: _________________________________________________

Firma del Apoderado: _____________    Huella Digital (Índice Derecho):


Lima, _____ de _________________ de 2026
",
    
    'salud' => "
DECLARACIÓN JURADA DE SALUD
(DE NO PADECER ENFERMEDADES CONTAGIOSAS)

Yo, _________________________ identificado(a) con DNI N.° _____________, 
domiciliado(a) en _____________________________________________________, 
en condición de postulante del proceso de admisión 2026 al Instituto de 
Educación Superior Tecnológico Público María Rosario Araoz Pinto, declaro 
bajo juramento que:

1. A la fecha NO PADEZCO de enfermedades contagiosas que representen un riesgo 
   para la salud pública.

2. NO presento síntomas de enfermedad como fiebre, cansancio, tos, dificultad 
   para respirar, dolor de garganta, o cualquier otra manifestación de 
   enfermedad transmisible.

3. NO he estado expuesto(a) a personas diagnosticadas con enfermedades 
   contagiosas en las últimas dos semanas.

4. NO me encuentro dentro de grupos de riesgo que puedan verse afectados por 
   enfermedades infecciosas.

5. No poseo ninguna condición médica que pueda poner en riesgo mi salud o la 
   de los demás en el ambiente académico.

6. Estoy en condiciones óptimas de salud para participar en el proceso de 
   admisión y posteriormente continuar con mis estudios en la institución.

En caso de resultar FALSA la información que proporciono, me someto a las 
responsabilidades administrativas, civiles y penales que correspondan conforme 
a las disposiciones normativas vigentes.


Apellidos y Nombres: ________________________________________________

DNI o Carné de Extranjería: __________________________________________

Firma: _________________________    Huella Digital (Índice Derecho):


Lima, _____ de _________________ de 2026


Declaración realizada bajo la responsabilidad penal del Código Penal Peruano.
"
];

if (!isset($contenidos[$tipo])) {
    die('Tipo de declaración inválido');
}

$contenido = $contenidos[$tipo];
$nombre_archivo = "Declaracion_" . ucfirst($tipo) . "_MRAP.txt";

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

echo $contenido;
exit;
?>