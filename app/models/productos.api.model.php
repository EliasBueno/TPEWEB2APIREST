<?php
class ProductosApiModel {

    // Variable para almacenar la conexión a la base de datos
    private $db;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct() {
        $this->db = $this->getDb();
    }

    // Método privado para obtener la conexión a la base de datos
    private function getDB() {
        // Crear la conexión PDO
        $db = new PDO('mysql:host=localhost;dbname=heladeriaa;charset=utf8', 'root', '');
        return $db;
    }

    // Obtener todos los productos con paginación
    public function getAll($page = 1, $limit = 10, $orderBy = 'nombre', $orderDirection = 'ASC') {
        $offset = ($page - 1) * $limit;

        try {
            // Establecer la conexión a la base de datos
            $pdo = new PDO('mysql:host=localhost;dbname=heladeriaa', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL con JOIN para obtener el nombre de la sucursal y ordenar por ese campo
            $query = "SELECT productos.*, sucursales.nombre AS sucursal_nombre
                      FROM productos 
                      JOIN sucursales ON productos.id_sucursal = sucursales.idSucursal
                      ORDER BY sucursales.nombre $orderDirection
                      LIMIT $limit OFFSET $offset";

            $stmt = $pdo->query($query);

            // Obtener los resultados y devolverlos
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productos;
            
        } catch (PDOException $e) {
            // Manejo de errores en la conexión o consulta
            die("Error al obtener los productos: " . $e->getMessage());
        }
    }



    // Obtener un producto por ID
    public function getById($id) {
        // Consultar un producto por su ID
        $query = $this->db->prepare("SELECT * FROM productos WHERE idProducto = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    // Obtener productos filtrados por "en oferta"
    public function getAllByOferta($enOferta) {
        // OPCIONAL: Filtrado de productos por estado de oferta (en_oferta)
        $query = $this->db->prepare("SELECT * FROM productos WHERE en_oferta = ?");
        $query->execute([$enOferta]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Filtrar productos por nombre, precio o estado de oferta
    public function getProductosFiltrados($params) {
        // OPCIONAL: Filtrado avanzado de productos por nombre, precio, o si están en oferta
        // Iniciar consulta base
        $sql = "SELECT * FROM productos WHERE 1";
    
        // Filtrar por nombre si está presente
        if (isset($params->nombre) && $params->nombre != "") {
            $sql .= " AND nombre LIKE '%" . $params->nombre . "%'";
        }
    
        // Filtrar por precio si está presente
        if (isset($params->precio) && $params->precio != "") {
            $sql .= " AND precio = " . $params->precio;
        }
    
        // Filtrar por oferta si está presente
        if (isset($params->en_oferta)) {
            $sql .= " AND en_oferta = " . $params->en_oferta;
        }
    
        // Ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // Retornar los resultados filtrados
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Agregar un producto nuevo
    public function add($nombre, $descripcion, $precio, $enOferta) {
        // Insertar un nuevo producto en la base de datos
        $query = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, en_oferta) VALUES (?, ?, ?, ?)");
        $query->execute([$nombre, $descripcion, $precio, $enOferta]);
        return $this->db->lastInsertId();
    }

    // Eliminar un producto
    public function delete($id) {
        // Eliminar el producto por su ID
        $query = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        $query->execute([$id]);
    }

    // Editar un producto existente
    public function edit($id, $nombre, $descripcion, $precio, $enOferta) {
        // Actualizar un producto en la base de datos
        $query = $this->db->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, en_oferta = ? WHERE id_producto = ?");
        $query->execute([$nombre, $descripcion, $precio, $enOferta, $id]);
    }
}
?>
