# Documentación del Proyecto: Gestión de Libros y Autores con MVC en PHP

## Título del Proyecto
**Desarrollo de una Aplicación Web en PHP con el Modelo MVC para la Gestión de Libros y Autores**
## Integrantes del Grupo

- Thalia Campoverde Maza
- Stefania Ojeda Rengel
- Gabriel Martínez Calahorrano

## Descripción General
Este proyecto es una aplicación web desarrollada en PHP que utiliza el patrón Modelo-Vista-Controlador (MVC) para gestionar libros y autores. Implementa un sistema de rutas amigables con un router personalizado y `.htaccess`, peticiones AJAX con Axios, una interfaz responsiva con Bootstrap, formularios en modales, y un menú de navegación dinámico. La aplicación permite realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) tanto para libros como para autores, con una base de datos relacional que vincula libros a sus respectivos autores.

El objetivo es cumplir con los requisitos funcionales establecidos en la Actividad de aprendizaje n.° 3, demostrando un diseño limpio, funcionalidad completa y una estructura bien organizada.

---

## Tecnologías Utilizadas
- **PHP 8.2**: Lenguaje principal para el backend.
- **MySQL**: Base de datos relacional gestionada con phpMyAdmin.
- **XAMPP**: Servidor local para desarrollo (Apache y MySQL).
- **Axios**: Biblioteca JavaScript para peticiones AJAX.
- **Bootstrap 5.3**: Framework CSS para diseño responsivo y modales.
- **HTML5 y JavaScript**: Frontend y lógica del cliente.
- **Git**: Control de versiones y entrega en GitHub.

---

## Estructura del Proyecto
El proyecto sigue el patrón MVC y está organizado en los siguientes directorios:

gestion_libros_autores/
├── assets/
│   └── js/
├── controllers/
│   ├── AutorController.php  # Controlador de autores
│   ├── LibroController.php  # Controlador de libros
│   └── HomeController.php   # Controlador de la página de inicio
├── models/
│   ├── Autor.php   # Modelo de autores
│   ├── Libro.php   # Modelo de libros
│   └── Database.php # Conexión a la base de datos
├── views/
│   ├── autores/
│   │   └── index.php  # Vista principal de autores
│   ├── libros/
│   │   └── index.php  # Vista principal de libros
│   ├── home/
│   │   └── index.php  # Vista de la página de inicio
│   └── layouts/
│       ├── header.php  # Encabezado común (menú de navegación)
│       └── footer.php  # Pie de página común
├── .htaccess         # Configuración de rutas amigables
├── index.php         # Punto de entrada único
├── Router.php        # Router personalizado
└── README.md         # Documentación (este archivo)

## Configuración

### Requisitos
- XAMPP con PHP 8.2 y MySQL.
- Editor de texto.

### Instalación
1. Clonar desde GitHub.
2. Colocar en C:\xampp\htdocs\gestion_libros_autores.
3. Crear base de datos gestion_libros con tablas autores (id, nombre) y libros (id, titulo, descripcion, autor_id).
4. Configurar models/Database.php con credenciales MySQL.
5. Iniciar XAMPP y visitar http://localhost/gestion_libros_autores/.

## Router
Dirige URLs a secciones como Inicio, Libros y Autores, y acciones como crear, actualizar o eliminar. El .htaccess redirige todo a index.php para URLs limpias.

## Axios
Maneja peticiones dinámicas desde el frontend, actualizando listas en tiempo real sin recargar la página.

## Bootstrap y Modales
Bootstrap 5.3 ofrece diseño responsivo. Los formularios de CRUD aparecen en modales para una experiencia fluida.

## Menú de Navegación
Navbar en layouts/header.php con enlaces a Inicio, Libros y Autores, adaptable a móviles.

## Requisitos Funcionales

### Página de Inicio
Muestra nombre del proyecto, integrantes, resumen y enlaces a Libros y Autores.

### Gestión de Libros
Lista con ID, título, descripción y autor, con botones para editar/eliminar. Modal para crear/editar con título, descripción y desplegable de autores.

### Gestión de Autores
Lista con ID y nombre, con botones para editar/eliminar. Modal para crear/editar con campo nombre.




