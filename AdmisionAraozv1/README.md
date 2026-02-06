# Sistema de Admisión 2026 - IESTP María Rosario Aráoz Pinto

Sistema web completo para gestionar el proceso de admisión del Instituto de Educación Superior Tecnológico Público María Rosario Aráoz Pinto.

## 📋 Características

✅ Landing page completa con información institucional  
✅ Formulario de inscripción multi-paso (5 pasos)  
✅ Validación en tiempo real de datos  
✅ Cálculo automático de edad (mayor/menor de edad)  
✅ Generación dinámica de declaraciones juradas  
✅ Subida de archivos con validación  
✅ Sistema de gestión de postulantes  
✅ Generación de código único de inscripción  
✅ Constancia de inscripción imprimible  
✅ Diseño responsive (móvil, tablet, desktop)  

## 🎨 Paleta de Colores

- **Verde Principal**: #006b3f
- **Verde Oscuro**: #004d2e
- **Verde Claro**: #e8f5e9
- **Naranja**: #ff8c42
- **Fondo Oscuro**: #1a1a1a
- **Gris Fondo**: #f5f5f5

## 🛠️ Requisitos del Sistema

### Software Necesario:
- **PHP**: 7.4 o superior
- **MySQL**: 8.0 o MariaDB 10.5+
- **Servidor Web**: Apache 2.4 o Nginx
- **Navegadores**: Chrome, Firefox, Safari, Edge (últimas versiones)

### Requisitos del Servidor:
- Procesador: Intel Core i3 o equivalente (2.0 GHz)
- RAM: 4 GB mínimo (Recomendado: 8 GB)
- Almacenamiento: 50 GB SSD
- Conexión a Internet: 10 Mbps

## 📦 Estructura de Archivos

```
/admision-mrap/
│
├── /config/
│   └── database.php          # Configuración de base de datos
│
├── /uploads/                 # Carpeta para archivos cargados
│   ├── /dni/
│   ├── /certificados/
│   └── /declaracion_jurada/
│
├── /admin/                   # Panel administrativo (próximamente)
│   ├── index.php
│   ├── postulantes.php
│   ├── examenes.php
│   └── reportes.php
│
├── /assets/                  # Recursos estáticos (opcional)
│   ├── /css/
│   ├── /js/
│   └── /images/
│
├── index.html                # Landing page principal
├── inscripcion.php           # Formulario de inscripción
├── procesar_inscripcion.php  # Backend inscripción
├── confirmacion.php          # Página de confirmación
├── descargar_declaracion.php # Generador de declaraciones
├── admision_mrap.sql         # Base de datos
└── README.md                 # Este archivo
```

## 🚀 Instalación

### Paso 1: Descargar los Archivos

Descarga todos los archivos del sistema y colócalos en la carpeta de tu servidor web:

- **XAMPP**: `C:/xampp/htdocs/admision-mrap/`
- **WAMP**: `C:/wamp64/www/admision-mrap/`
- **Linux**: `/var/www/html/admision-mrap/`

### Paso 2: Crear la Base de Datos

1. Abre **phpMyAdmin** en tu navegador:
   ```
   http://localhost/phpmyadmin
   ```

2. Crea una nueva base de datos:
   - Haz clic en "Nueva" en el panel izquierdo
   - Nombre: `admision_mrap`
   - Cotejamiento: `utf8mb4_unicode_ci`
   - Haz clic en "Crear"

3. Importa el archivo SQL:
   - Selecciona la base de datos `admision_mrap`
   - Haz clic en la pestaña "Importar"
   - Selecciona el archivo `admision_mrap.sql`
   - Haz clic en "Continuar"

### Paso 3: Configurar la Conexión a la Base de Datos

Abre el archivo `config/database.php` y verifica/modifica las credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'admision_mrap');
define('DB_USER', 'root');         // Tu usuario de MySQL
define('DB_PASS', '');             // Tu contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');
```

### Paso 4: Crear las Carpetas de Upload

Crea las siguientes carpetas y asigna permisos de escritura:

```bash
# Windows (No necesita permisos especiales)
mkdir uploads
mkdir uploads/dni
mkdir uploads/certificados
mkdir uploads/declaracion_jurada

# Linux/Mac (Asignar permisos)
mkdir -p uploads/{dni,certificados,declaracion_jurada}
chmod -R 777 uploads/
```

### Paso 5: Probar el Sistema

1. Abre tu navegador y accede a:
   ```
   http://localhost/admision-mrap/index.html
   ```

2. Verifica que la página principal se cargue correctamente

3. Haz clic en "INSCRIBIRSE" para probar el formulario

## 🔐 Acceso al Panel Administrativo

### Usuario por Defecto:
- **Usuario**: admin
- **Contraseña**: admin123

⚠️ **IMPORTANTE**: Cambia la contraseña por defecto después de la primera instalación.

Para cambiar la contraseña:
```sql
UPDATE usuarios_admin 
SET password_hash = '$2y$10$TU_NUEVO_HASH' 
WHERE username = 'admin';
```

Genera un nuevo hash con:
```php
<?php echo password_hash('tu_nueva_contraseña', PASSWORD_DEFAULT); ?>
```

## 📝 Uso del Sistema

### Para Postulantes:

1. **Acceder a la página principal**
   - Visitar: `http://localhost/admision-mrap/`

2. **Revisar información**
   - Carreras disponibles
   - Proceso de admisión
   - Requisitos
   - Cronograma

3. **Iniciar inscripción**
   - Clic en "INSCRIBIRSE"
   - Completar 5 pasos del formulario
   - Descargar y firmar declaraciones
   - Subir documentos requeridos

4. **Obtener código de inscripción**
   - Imprimir constancia
   - Realizar pago de S/. 150.00

### Paso a Paso del Formulario:

**Paso 1: Datos Personales**
- Nombres, apellidos, DNI
- Fecha de nacimiento (calcula edad automáticamente)
- Email, teléfono, dirección

**Paso 2: Información Académica**
- Colegio de procedencia
- Grado actual
- Promedio último año

**Paso 3: Selección de Programas**
- Primera opción de carrera + turno
- Segunda opción de carrera + turno
- Datos del apoderado
- Aceptación de términos

**Paso 4: Documentos**
- Copia de DNI (PDF/imagen)
- Certificados de estudios (PDF)

**Paso 5: Declaraciones Juradas**
- Descargar declaraciones según edad
- Firmar documentos
- Subir declaraciones firmadas (PDF)

## 🗄️ Estructura de la Base de Datos

### Tablas Principales:

1. **postulantes** - Datos personales del postulante
2. **informacion_academica** - Historial académico
3. **apoderados** - Datos del responsable legal
4. **programas_estudio** - Catálogo de carreras (9 carreras)
5. **opciones_carrera** - Selección de programas (1ra y 2da opción)
6. **documentos** - Archivos digitales cargados
7. **declaraciones_juradas** - Registros de aceptación
8. **examenes_admision** - Programación de exámenes
9. **inscripciones_examen** - Relación postulante-examen
10. **resultados_examen** - Calificaciones obtenidas
11. **usuarios_admin** - Usuarios del sistema
12. **logs_sistema** - Auditoría del sistema

## ⚙️ Configuración Adicional

### Modificar Límite de Subida de Archivos

Edita `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

Reinicia Apache después de los cambios.

### Configurar Email (Opcional)

Para enviar emails de confirmación, configura en `procesar_inscripcion.php`:

```php
$headers = "From: admision@institutoaraozpinto.com" . "\r\n";
```

Considera usar servicios como:
- SendGrid
- Mailgun
- Amazon SES
- PHPMailer con SMTP

### Backup Automático

Crea un script para backup diario:

```bash
#!/bin/bash
mysqldump -u root -p admision_mrap > backup_$(date +%Y%m%d).sql
```

## 🔧 Solución de Problemas

### Error: "No se puede conectar a la base de datos"
- Verifica que MySQL esté corriendo
- Comprueba las credenciales en `config/database.php`
- Asegúrate de haber creado la base de datos

### Error: "No se pueden subir archivos"
- Verifica permisos de la carpeta `uploads/`
- Revisa la configuración de `upload_max_filesize` en `php.ini`

### Error: "Las imágenes no se cargan"
- Verifica las rutas de los archivos
- Comprueba que Bootstrap CSS y JS se carguen correctamente

### La página se ve sin estilos
- Verifica tu conexión a internet (usa CDN)
- Revisa la consola del navegador (F12) para errores

## 📱 Responsive Design

El sistema es completamente responsive y funciona en:

- 📱 **Móviles**: 320px - 767px
- 📱 **Tablets**: 768px - 1024px
- 💻 **Desktop**: 1025px en adelante

## 🔒 Seguridad

Medidas de seguridad implementadas:

✅ Validación de datos en cliente y servidor  
✅ Prepared statements (previene SQL Injection)  
✅ Sanitización de datos de entrada  
✅ Hashing de contraseñas (bcrypt)  
✅ Protección CSRF (pendiente)  
✅ Validación de tipos de archivo  
✅ Límites de tamaño de archivo  
✅ Logs de auditoría  

### Recomendaciones adicionales:

1. Usar HTTPS en producción
2. Implementar rate limiting
3. Agregar CAPTCHA al formulario
4. Configurar WAF (Web Application Firewall)
5. Realizar backups regulares

## 🚀 Despliegue en Producción

### Requisitos para Servidor en Producción:

1. **Dominio propio**: institutoaraozpinto.com
2. **Certificado SSL**: Let's Encrypt (gratuito)
3. **Hosting recomendado**:
   - Hostinger
   - DreamHost
   - SiteGround
   - AWS / DigitalOcean (avanzado)

### Checklist antes de lanzar:

- [ ] Cambiar contraseñas por defecto
- [ ] Configurar backups automáticos
- [ ] Instalar certificado SSL
- [ ] Configurar envío de emails
- [ ] Probar en múltiples dispositivos
- [ ] Verificar velocidad de carga
- [ ] Configurar Google Analytics (opcional)
- [ ] Probar todo el flujo de inscripción

## 📊 Próximas Funcionalidades

- [ ] Panel administrativo completo
- [ ] Sistema de reportes y estadísticas
- [ ] Examen de admisión en línea
- [ ] Integración con pasarelas de pago
- [ ] Notificaciones por SMS y email
- [ ] Aplicación móvil nativa
- [ ] Dashboard con gráficos interactivos
- [ ] Exportación de datos a Excel
- [ ] Sistema de calificaciones
- [ ] Portal del estudiante

## 📄 Licencia

Este proyecto es propiedad del **Instituto de Educación Superior Tecnológico Público María Rosario Aráoz Pinto**.

Todos los derechos reservados © 2025

## 👥 Soporte y Contacto

Para soporte técnico o consultas:

- **Email**: contacto@institutoaraozpinto.com
- **Teléfono**: [Agregar teléfono]
- **Dirección**: Calle José Martí 155, San Miguel, Lima - Perú

## 🎓 Créditos

Desarrollado para el proceso de Admisión 2026 del IESTP María Rosario Aráoz Pinto.

**Tecnologías utilizadas**:
- HTML5, CSS3, JavaScript
- PHP 7.4+
- MySQL 8.0
- Bootstrap 5.3.2
- Bootstrap Icons

---

**Última actualización**: Noviembre 2025  
**Versión**: 1.0.0  
**Estado**: Producción
