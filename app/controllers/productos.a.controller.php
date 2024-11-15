<?php
require_once "./app/models/productos.api.model.php";
require_once "./app/views/motor.api.view.php";
class ProductosAController {

    private $model;

    public function __construct() {
        $this->model = new ProductosApiModel();
    }

    // Obtener todos los productos con paginación
    public function getProductos($params) {
        // Establecer la página actual
        if (isset($params['page']) && !empty($params['page'])) {
            $page = (int)$params['page'];
        } else {
            $page = 1; // Página por defecto
        }
    
        $perPage = 10; // Productos por página
    
        // Obtener el parámetro 'sort' (campo de ordenación)
        if (isset($params['sort']) && !empty($params['sort'])) {
            $sort = $params['sort'];
        } else {
            $sort = 'nombre';  // Valor por defecto si no se especifica 'sort'
        }
    
        // Obtener el parámetro 'order' (dirección de ordenación)
        if (isset($params['order']) && !empty($params['order'])) {
            $order = strtoupper($params['order']);
        } else {
            $order = 'ASC';  // Valor por defecto si no se especifica 'order'
        }
    
        // Validar que 'order' sea 'ASC' o 'DESC'
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'ASC'; // Valor por defecto si la dirección no es válida
        }
    
        // Llamar al modelo para obtener los productos ordenados
        $productos = $this->model->getAll($page, $perPage, $sort, $order);
    
        // Responder con los productos ordenados
        (new MotorApiView())->response($productos, 200);
    }
    

    // Obtener un producto por ID
    public function getProductoById($params) {
        if (isset($params[':ID']) && !empty($params[':ID'])) {
            $producto = $this->model->getById($params[':ID']);
            if ($producto) {
                (new MotorApiView())->response($producto, 200);
            } else {
                (new MotorApiView())->response(['message' => 'Producto no encontrado'], 404);
            }
        } else {
            (new MotorApiView())->response(['message' => 'ID inválido'], 400);
        }
    }

    // Obtener productos en oferta
    public function getProductosEnOferta($params) {
        $productos = $this->model->getAllByOferta(1); // 1 significa que está en oferta
        (new MotorApiView())->response($productos, 200);
    }

    // Filtrar productos
    public function getProductosFiltrados($params) {
        // Crear un objeto para pasar como parámetros
        $filters = new stdClass();
        
        // Asignar los parámetros de filtrado, si están presentes
        if (isset($params['nombre']) && !empty($params['nombre'])) {
            $filters->nombre = $params['nombre'];
        }
        
        if (isset($params['precio']) && !empty($params['precio'])) {
            $filters->precio = $params['precio'];
        }
        
        if (isset($params['en_oferta']) && !empty($params['en_oferta'])) {
            $filters->en_oferta = $params['en_oferta'];
        }
    
        // Llamar al modelo para obtener los productos filtrados
        $productos = $this->model->getProductosFiltrados($filters);
    
        // Devolver la respuesta con los productos filtrados
        (new MotorApiView())->response($productos, 200);
    }

    // Agregar un producto
    public function addProducto($params) {
        $body = json_decode(file_get_contents("php://input"));
        if (isset($body->nombre) && !empty($body->nombre) && isset($body->descripcion) && !empty($body->descripcion) && isset($body->precio) && !empty($body->precio)) {
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $enOferta = isset($body->en_oferta) ? $body->en_oferta : 0; // Si no se pasa en_oferta, por defecto será 0

            $id = $this->model->add($nombre, $descripcion, $precio, $enOferta);
            (new MotorApiView())->response(['id_producto' => $id], 201);
        } else {
            (new MotorApiView())->response(['message' => 'Datos incompletos'], 400);
        }
    }

    // Eliminar un producto
    public function deleteProducto($params) {
        if (isset($params[':ID']) && !empty($params[':ID'])) {
            $this->model->delete($params[':ID']);
            (new MotorApiView())->response(['message' => 'Producto eliminado'], 200);
        } else {
            (new MotorApiView())->response(['message' => 'ID inválido'], 400);
        }
    }

    // Editar un producto
    public function editProducto($params) {
        $body = json_decode(file_get_contents("php://input"));
        if (isset($body->nombre) && !empty($body->nombre) && isset($body->descripcion) && !empty($body->descripcion) && isset($body->precio) && !empty($body->precio)) {
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $enOferta = isset($body->en_oferta) ? $body->en_oferta : 0;

            $this->model->edit($params[':ID'], $nombre, $descripcion, $precio, $enOferta);
            (new MotorApiView())->response(['message' => 'Producto actualizado'], 200);
        } else {
            (new MotorApiView())->response(['message' => 'Datos incompletos'], 400);
        }
    }
}
?>
