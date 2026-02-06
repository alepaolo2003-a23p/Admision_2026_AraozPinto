🎓 Sistema de Gestión de Admisión 2026 - IESTP "María Rosario Aráoz Pinto"
Descripción del Proyecto
Este sistema es una plataforma integral desarrollada para digitalizar y centralizar el proceso de captación e inscripción de postulantes del IESTP María Rosario Aráoz Pinto. El objetivo principal es reemplazar los procesos manuales por una solución automatizada que garantice la integridad de los datos, reduzca los tiempos de espera y proporcione reportes en tiempo real para la administración institucional.

🛠️ Stack Tecnológico
Backend: PHP 8.x (Arquitectura modular).

Base de Datos: MySQL (Diseño relacional con integridad referencial).

Frontend: HTML5, CSS3, JavaScript (ES6).

Framework UI: Bootstrap 5 para un diseño Mobile-First.

Herramientas: Git/GitHub, XAMPP.

📦 Módulos Implementados
1. Módulo de Registro y Postulación (Frontend)
Formulario Dinámico: Registro de datos personales, dirección, datos de contacto y selección de carrera profesional.

Validación de Datos: Doble capa de validación. JavaScript en el cliente para feedback inmediato y PHP en el servidor para evitar inyecciones o datos corruptos.

Gestión de Documentos: Lógica para la carga y verificación de requisitos (DNI, Certificados).

2. Módulo de Administración (Dashboard)
Control de Acceso: Sistema de autenticación seguro para administradores con manejo de sesiones en PHP.

Panel de Control: Visualización de métricas clave (total de inscritos, carreras con mayor demanda).

Gestión de Aspirantes (CRUD): Interfaz completa para visualizar, editar, aprobar o rechazar solicitudes de inscripción.

3. Módulo de Configuración Académica
Gestión de Carreras: Módulo para dar de alta o modificar las especialidades ofrecidas por el instituto.

Control de Vacantes: Lógica programada para limitar las inscripciones según el cupo disponible por carrera.

4. Reportes y Exportación
Generación de Listados: Consultas SQL avanzadas para filtrar postulantes por estado, carrera o fecha.

Exportación de Datos: (Opcional si lo tienes) Funcionalidad para descargar la lista de aptos en formatos legibles.

⚙️ Arquitectura Técnica
Conexión Segura: Uso de PDO o MySQLi con sentencias preparadas para mitigar ataques de SQL Injection.

Estructura de Carpetas:

/assets: Estilos (CSS), scripts (JS) e imágenes.

/config: Archivos de conexión a la base de datos y constantes globales.

/includes: Componentes reutilizables (header, footer, nav).

/admin: Lógica y vistas exclusivas del panel administrativo.

📐 Estándares de Calidad (ISO/IEC 25010)
Como estudiante de la carrera de Desarrollo de Sistemas de Información, este proyecto ha sido construido bajo principios de ingeniería de software:

Adecuación Funcional: El sistema cubre el 100% de los requisitos del proceso de admisión.

Usabilidad: Interfaz limpia y fácil de usar para usuarios con conocimientos básicos de tecnología.

Seguridad: Implementación de validaciones de lado del servidor y manejo de sesiones.

🚀 Instalación y Uso
Clonar: git clone https://github.com/alepaolo2003-a23p/Admision_2026_AraozPinto.git

Base de Datos: Importar el archivo db_admision.sql en tu gestor de MySQL (phpMyAdmin).

Configurar: Editar el archivo config/db.php con tus credenciales locales.

Ejecutar: Abrir en el navegador a través de http://localhost/Admision_2026_AraozPinto.

👤 Autor
Alessandro Paolo Zelada Falconi

Estudiante de 5to ciclo - IESTP María Rosario Aráoz Pinto.
