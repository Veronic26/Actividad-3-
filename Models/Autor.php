<?php
require_once 'Database.php';  // Incluir el archivo Database

class Autor {
    private $conn;
    private $table = 'autores'; // La tabla en la base de datos

    public function __construct() {
        // Instanciar la clase Database
        $database = new Database();
        $this->conn = $database->getConnection();  // Usar el método conectar()
    }

    // Obtener todos los autores
    public function obtenerAutores() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo autor
    public function agregarAutor($nombre) {
        $query = "INSERT INTO " . $this->table . " (nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        
        // Ejecutar la consulta y devolver el resultado
        return $stmt->execute();
    }

    // Eliminar autor
    public function eliminarAutor($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Obtener un autor por su ID
    public function obtenerAutorPorId($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar autor
    public function actualizarAutor($id, $nombre) {
        $query = "UPDATE " . $this->table . " SET nombre = :nombre WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
