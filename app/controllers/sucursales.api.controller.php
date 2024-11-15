<?php

require_once "./app/models/sucursales.api.model.php";
require_once "./app/views/motor.api.view.php";

class sucursalesapicontroller {

    private $model;

    public function __construct() {
        $this->model = new sucursalesapimodel();
    }

    // Método para obtener todas las sucursales
    public function getSucursales($params) {
        // Establecer la página actual
        if (isset($params['page']) && !empty($params['page'])) {
            $page = (int)$params['page'];
        } else {
            $page = 1; // Página por defecto
        }

        $perPage = 10; // Sucursales por página

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

        // Llamar al modelo para obtener las sucursales ordenadas
        $sucursales = $this->model->getAll($page, $perPage, $sort, $order);

        // Responder con las sucursales ordenadas
        (new MotorApiView())->response($sucursales, 200);
    }

    // Método para obtener una sucursal por su ID
    public function getSucursalById($params) {
        $id = $params[':ID']; // Obtener el ID de la sucursal desde los parámetros de la ruta

        $sucursal = $this->model->getById($id);

        if ($sucursal) {
            // Responder con la sucursal encontrada
            (new MotorApiView())->response($sucursal, 200);
        } else {
            // Responder con un error si no se encuentra la sucursal
            (new MotorApiView())->response(['error' => 'Sucursal no encontrada'], 404);
        }
    }

    // Método para agregar una nueva sucursal
    public function addSucursal($params) {
        // Obtener los datos de la sucursal desde el cuerpo de la solicitud (JSON)
        $data = json_decode(file_get_contents('php://input'), true);
    
        // Validar que los datos estén completos
        if (isset($data['nombre']) && isset($data['ubicacion']) && isset($data['imagen'])) {
            // Llamar al modelo para agregar la sucursal
            $idSucursal = $this->model->add($data['nombre'], $data['ubicacion'], $data['imagen']);
    
            if ($idSucursal) {
                // Obtener toda la información de la sucursal recién creada
                $sucursal = $this->model->getById($idSucursal);  // Método para obtener los detalles completos de la sucursal
    
                if ($sucursal) {
                    // Responder con la sucursal completa (nombre, ubicacion, imagen, id, etc.)
                    (new MotorApiView())->response($sucursal, 201);
                } else {
                    // Responder con un error si no se pudo recuperar la sucursal creada
                    (new MotorApiView())->response(['error' => 'Error al recuperar los datos de la sucursal'], 500);
                }
            } else {
                // Responder con un error si no se pudo agregar la sucursal
                (new MotorApiView())->response(['error' => 'Error al agregar la sucursal'], 500);
            }
        } else {
            // Responder con un error si los datos están incompletos
            (new MotorApiView())->response(['error' => 'Datos inválidos. Se requiere nombre, ubicación e imagen.'], 400);
        }
    }
    
    

    // Método para editar una sucursal
    public function editSucursal($params) {
        $id = $params[':ID']; // Obtener el ID de la sucursal desde los parámetros de la ruta
    
        // Obtener los datos actualizados desde el cuerpo de la solicitud (JSON)
        $data = json_decode(file_get_contents('php://input'), true);
    
        // Validar que los datos estén completos
        if (isset($data['nombre']) && isset($data['ubicacion']) && isset($data['imagen'])) {
            // Llamar al modelo para editar la sucursal
            $this->model->edit($id, $data['nombre'], $data['ubicacion'], $data['imagen']);
    
            // Obtener la sucursal actualizada para devolver todos los detalles
            $sucursal = $this->model->getById($id); // Asegúrate de tener este método en el modelo para obtener una sucursal por ID
    
            if ($sucursal) {
                // Responder con los detalles de la sucursal actualizada
                (new MotorApiView())->response($sucursal, 200);
            } else {
                // Si no se puede recuperar la sucursal después de la actualización
                (new MotorApiView())->response(['error' => 'Error al recuperar los datos actualizados de la sucursal'], 500);
            }
        } else {
            // Responder con un error si los datos son inválidos o faltantes
            (new MotorApiView())->response(['error' => 'Datos inválidos. Se requiere nombre, ubicación e imagen.'], 400);
        }
    }
    
    

    // Método para eliminar una sucursal
     // Método para eliminar una sucursal
     public function deleteSucursal($params) {
        $id = $params[':ID']; // Obtener el ID de la sucursal desde los parámetros de la ruta

        // Validar si la sucursal existe antes de intentar eliminarla
        $sucursal = $this->model->getById($id);

        if ($sucursal) {
            // Llamar al modelo para eliminar la sucursal
            $this->model->delete($id);

            // Responder con éxito
            (new MotorApiView())->response(['message' => 'Sucursal eliminada'], 200);
        } else {
            // Responder con un error si la sucursal no existe
            (new MotorApiView())->response(['error' => 'Sucursal no encontrada'], 404);
        }
    }
    
}
?>
