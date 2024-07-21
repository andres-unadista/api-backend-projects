# Plataforma de gestión de proyectos con funcionalidades de autenticación y seguimiento de tareas

## Requisitos

Asegúrate de tener los siguientes requisitos instalados en tu máquina:

- [PHP](https://www.php.net/) 8.0 o superior
- [Composer](https://getcomposer.org/) para la gestión de dependencias
- [MySQL](https://www.mysql.com/) o cualquier otra base de datos compatible
- [Node.js](https://nodejs.org/) (Opcional para la gestión de recursos front-end)
- [NPM](https://www.npmjs.com/) o [Yarn](https://yarnpkg.com/) (Opcional para la gestión de recursos front-end)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local:

### 1. **Clona el repositorio:**
   ``` git clone https://github.com/andres-unadista/api-backend-projects.git ```
### 2.	Navega al directorio del proyecto:
cd nombre_del_proyecto
### 3.	Instala las dependencias de PHP con Composer:
```composer install```
### 4.	Instala las dependencias de Node.js con NPM (opcional):
Si tu proyecto utiliza recursos front-end, puedes instalar las dependencias de Node.js con:
 ``` npm install```
O si prefieres usar Yarn:
```yarn install```
### 5.	Configura el archivo .env:
Crea una copia del archivo .env.example y renómbrala a .env:
```cp .env.example .env```
Luego, abre el archivo .env en tu editor de texto y configura las siguientes variables:
Asegúrate de reemplazar nombre_de_la_base_de_datos, tu_usuario y tu_contraseña con los datos correctos de tu base de datos.
### 6.	Genera la clave de aplicación:
Ejecuta el siguiente comando para generar una clave de aplicación:
```php artisan key:generate```
### 7.	Inicia el servidor de desarrollo:
Para ejecutar el servidor de desarrollo, usa el siguiente comando:
```php artisan serve```
