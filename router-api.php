<?php
// Incluye las clases necesarias para el enrutamiento y controladores
require_once "./libs/Router.php";  // Asegúrate de que esta clase esté correctamente ubicada
require_once "./app/controllers/productos.a.controller.php"; // Controlador de productos
require_once "./app/controllers/sucursales.api.controller.php"; // Controlador de sucursales

// Crea una instancia del enrutador
$router = new Router();

// Rutas de productos (cambia la URL de acuerdo a lo que necesites)
$router->addRoute('productos', 'GET', 'productosacontroller', 'getProductos'); // Obtiene todos los productos
$router->addRoute('productos/:ID', 'GET', 'productosacontroller', 'getProductoById'); // Obtiene un producto por ID
$router->addRoute('productos/en_oferta', 'GET', 'productosacontroller', 'getProductosEnOferta'); // Productos en oferta
$router->addRoute('productos', 'POST', 'productosacontroller', 'addProducto'); // Agregar un nuevo producto
$router->addRoute('productos/:ID', 'PUT', 'productosacontroller', 'editProducto'); // Editar un producto
$router->addRoute('productos/:ID', 'DELETE', 'productosacontroller', 'deleteProducto'); // Eliminar un producto

// Rutas de sucursales
$router->addRoute('sucursales', 'GET', 'sucursalesapicontroller', 'getSucursales'); // Obtiene todas las sucursales
$router->addRoute('sucursales/:ID', 'GET', 'sucursalesapicontroller', 'getSucursalById'); // Obtiene una sucursal por ID
$router->addRoute('sucursales/:ID', 'DELETE', 'sucursalesapicontroller', 'deleteSucursal'); // Eliminar una sucursal
$router->addRoute('sucursales', 'POST', 'sucursalesapicontroller', 'addSucursal'); // Agregar una nueva sucursal
$router->addRoute('sucursales/:ID', 'PUT', 'sucursalesapicontroller', 'editSucursal'); // Editar una sucursal

// Procesa la solicitud según la ruta y el método HTTP recibido
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']); 
