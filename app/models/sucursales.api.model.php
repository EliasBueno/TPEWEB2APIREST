<?php
class sucursalesapimodel {

    // Variable para almacenar la conexión a la base de datos
    private $db;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct() {
        $this->db = $this->getDb();
    }

    // Método privado para obtener la conexión a la base de datos
    private function getDb() {
        // Crear la conexión PDO
        $db = new PDO('mysql:host=localhost;dbname=heladeriaa;charset=utf8', 'root', '');
        return $db;
    }

    // Método para obtener todas las sucursales
    public function getAll() {
        // Consultar todas las sucursales en la base de datos
        $query = $this->db->prepare("SELECT * FROM sucursales");
        $query->execute();
        
        // Retornar todas las sucursales como un array de objetos
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener una sucursal por su ID
    public function getById($id) {
        // Consultar la sucursal por su ID
        $query = $this->db->prepare("SELECT * FROM sucursales WHERE idSucursal = ?");
        $query->execute([$id]);
        
        // Retornar la sucursal encontrada
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Método para agregar una nueva sucursal
    public function add($nombre, $ubicacion, $imagen) {
        // Insertar la nueva sucursal en la base de datos
        $query = $this->db->prepare("INSERT INTO sucursales (nombre, ubicacion, imagen) VALUES (?, ?, ?)");
        $query->execute([$nombre, $ubicacion, $imagen]);
    
        // Retornar el ID de la nueva sucursal insertada
        return $this->db->lastInsertId();
    }

    // Método para eliminar una sucursal por su ID
    public function delete($id) {
        try {
            // Eliminar la sucursal de la base de datos
            $query = $this->db->prepare("DELETE FROM sucursales WHERE idSucursal = ?");
            $query->execute([$id]);
        } catch (Exception $e) {
            // Si ocurre un error, devolverlo
            return $e;
        }
    }

    // Método para editar una sucursal existente
    public function edit($id, $nombre, $ubicacion, $imagen) {
        // Actualizar los datos de la sucursal en la base de datos
        $query = $this->db->prepare("UPDATE sucursales SET nombre = ?, ubicacion = ?, imagen = ? WHERE idSucursal = ?");
        $query->execute([$nombre, $ubicacion, $imagen, $id]);
    }
}
?>
