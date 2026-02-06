# Panel Administrativo - IESTP María Rosario Araoz Pinto

## 📋 Descripción

Panel de administración completo para gestionar el proceso de admisión del instituto. Permite visualizar, gestionar y analizar toda la información de postulantes, exámenes y programas de estudio.

## 🔐 Acceso al Sistema

### URL de Acceso
```
http://localhost/admision-mrap/admin/login.php
```

### Credenciales por Defecto
- **Usuario:** admin
- **Contraseña:** admin123

⚠️ **IMPORTANTE:** Cambia estas credenciales después de la primera instalación.

## 🎯 Funcionalidades Principales

### 1. Dashboard (index.php)
- Vista general de estadísticas
- Contador de postulantes totales
- Inscripciones pendientes y completadas
- Gráficos de distribución por carreras
- Últimos postulantes registrados

### 2. Gestión de Postulantes (postulantes.php)
- Lista completa de todos los postulantes
- Filtros por:
  - Estado (pendiente, completado, rechazado)
  - Carrera seleccionada
  - Búsqueda por nombre, DNI o email
- Exportación a Excel y PDF
- Acciones:
  - Ver detalles completos
  - Editar información
  - Eliminar postulante

### 3. Detalle del Postulante (ver_postulante.php)
Información completa del postulante:
- Datos personales
- Información académica
- Programas seleccionados
- Información del apoderado
- Documentos adjuntos
- Estado de inscripción
- Datos del examen asignado
- Cambio de estado de inscripción

### 4. Gestión de Exámenes (examenes.php)
- Lista de todos los exámenes programados
- Creación de nuevos exámenes
- Información de cada examen:
  - Código único
  - Fecha y hora
  - Duración
  - Aula asignada
  - Capacidad y cantidad de inscritos
  - Estado (programado, en curso, finalizado, cancelado)
- Lista de asistencia
- Edición de exámenes existentes

### 5. Reportes y Estadísticas (reportes.php)
Análisis completo con:
- Resumen de pagos (pagados, pendientes, total recaudado)
- Distribución por:
  - Carreras
  - Turnos (diurno/nocturno)
  - Rangos de edad
  - Nivel educativo
- Gráficos interactivos
- Tendencia de inscripciones por mes
- Exportación de reportes

## 📁 Estructura de Archivos

```
/admin/
│
├── /includes/
│   ├── auth.php          # Funciones de autenticación
│   ├── header.php        # Header común
│   ├── sidebar.php       # Menú lateral
│   └── footer.php        # Footer común
│
├── login.php             # Página de inicio de sesión
├── logout.php            # Cerrar sesión
├── index.php             # Dashboard principal
├── postulantes.php       # Gestión de postulantes
├── ver_postulante.php    # Detalle de postulante
├── editar_postulante.php # Editar postulante
├── eliminar_postulante.php # Eliminar postulante
├── examenes.php          # Gestión de exámenes
├── ver_examen.php        # Detalle de examen
├── editar_examen.php     # Editar examen
├── lista_asistencia.php  # Lista de asistencia
├── programas.php         # Gestión de programas
├── documentos.php        # Gestión de documentos
├── reportes.php          # Reportes y estadísticas
├── usuarios.php          # Gestión de usuarios admin
├── logs.php              # Logs del sistema
├── configuracion.php     # Configuración general
└── exportar.php          # Exportación de datos
```

## 👥 Roles de Usuario

El sistema admite 3 roles:

1. **Admin** (Administrador)
   - Acceso completo a todas las funciones
   - Gestión de usuarios
   - Configuración del sistema

2. **Coordinador**
   - Gestión de postulantes
   - Gestión de exámenes
   - Visualización de reportes
   - NO puede gestionar usuarios

3. **Evaluador**
   - Solo visualización
   - Acceso a lista de postulantes
   - Acceso a lista de exámenes
   - NO puede editar ni eliminar

## 🎨 Paleta de Colores

- **Verde Principal:** #006b3f
- **Verde Oscuro:** #004d2e
- **Verde Claro:** #e8f5e9
- **Naranja:** #ff8c42

## 🔧 Funciones de Seguridad

### Autenticación
- Sistema de sesiones PHP
- Verificación en cada página
- Cierre de sesión automático por inactividad
- Registro de accesos en logs

### Protección de Datos
- Prepared statements (previene SQL Injection)
- Sanitización de datos de entrada
- Validación de permisos por rol
- Logs de auditoría

## 📊 Estadísticas y Reportes

### Métricas Disponibles

1. **Postulantes:**
   - Total de postulantes
   - Pendientes/Completados/Rechazados
   - Inscripciones del día
   - Distribución por edad
   - Distribución por nivel educativo

2. **Carreras:**
   - Postulantes por carrera
   - Primera vs Segunda opción
   - Distribución por turno

3. **Pagos:**
   - Total pagado/pendiente
   - Monto recaudado
   - Tasa de conversión

4. **Exámenes:**
   - Exámenes programados
   - Capacidad vs Inscritos
   - Tasa de asistencia

## 🖨️ Exportación de Datos

### Formatos Disponibles:
- **Excel (.xlsx):** Para análisis de datos
- **PDF:** Para impresión y archivo
- **CSV:** Para integración con otros sistemas

### Datos Exportables:
- Lista completa de postulantes
- Reportes estadísticos
- Lista de asistencia a exámenes
- Reportes de pagos

## 🔄 Actualizaciones y Mantenimiento

### Cambiar Contraseña de Admin

Ejecuta este SQL en phpMyAdmin:

```sql
UPDATE usuarios_admin 
SET password_hash = '$2y$10$TU_NUEVO_HASH' 
WHERE username = 'admin';
```

Genera el hash con PHP:
```php
<?php echo password_hash('tu_nueva_contraseña', PASSWORD_DEFAULT); ?>
```

### Crear Nuevo Usuario Administrador

```sql
INSERT INTO usuarios_admin (username, password_hash, nombre_completo, email, rol, activo) 
VALUES (
    'nuevo_usuario',
    '$2y$10$HASH_GENERADO',
    'Nombre Completo',
    'email@ejemplo.com',
    'coordinador',
    1
);
```

### Limpiar Logs Antiguos

```sql
DELETE FROM logs_sistema 
WHERE fecha_hora < DATE_SUB(NOW(), INTERVAL 6 MONTH);
```

## 🐛 Solución de Problemas

### Error: "No se puede conectar"
- Verifica que Apache y MySQL estén corriendo
- Comprueba las credenciales en `config/database.php`

### Error: "Acceso denegado"
- Verifica que el usuario tenga los permisos correctos
- Comprueba que la sesión esté activa

### Las gráficas no se muestran
- Verifica que haya datos en la base de datos
- Comprueba la consola del navegador (F12)
- Asegúrate de que Chart.js esté cargando correctamente

### Error al exportar
- Verifica permisos de escritura en la carpeta
- Comprueba que las librerías necesarias estén instaladas

## 📱 Responsive Design

El panel es completamente responsive:
- ✅ Desktop (1920px+)
- ✅ Laptop (1366px)
- ✅ Tablet (768px - 1024px)
- ✅ Móvil (320px - 767px)

## 🔒 Mejores Prácticas de Seguridad

1. **Cambiar contraseñas por defecto**
2. **Usar HTTPS en producción**
3. **Limitar intentos de login**
4. **Implementar CAPTCHA**
5. **Realizar backups regulares**
6. **Mantener logs de auditoría**
7. **Revisar permisos de usuarios periódicamente**

## 📞 Soporte

Para soporte técnico o consultas:
- Email: soporte@institutoaraozpinto.com
- Documentación adicional en el README principal del proyecto

## 📝 Notas de Versión

**Versión 1.0.0** (Noviembre 2025)
- Panel administrativo inicial
- Gestión completa de postulantes
- Sistema de exámenes
- Reportes y estadísticas
- Sistema de roles y permisos

---

**Última actualización:** Noviembre 2025
**Desarrollado para:** IESTP María Rosario Araoz Pinto
