<?php
require_once 'Database.php';

class Libro {
    private $conn;
    private $table = 'libros';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los libros
    public function obtenerLibros() {
        $query = "SELECT l.id, l.titulo, l.descripcion, l.autor_id, a.nombre AS autor_nombre 
                  FROM " . $this->table . " l 
                  LEFT JOIN autores a ON l.autor_id = a.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo libro
    public function agregarLibro($titulo, $descripcion, $autor_id) {
        $query = "INSERT INTO " . $this->table . " (titulo, descripcion, autor_id) 
                  VALUES (:titulo, :descripcion, :autor_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':autor_id', $autor_id);
        return $stmt->execute();
    }

    // Eliminar un libro
    public function eliminarLibro($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Obtener un libro por su ID
    public function obtenerLibroPorId($id) {
        $query = "SELECT l.id, l.titulo, l.descripcion, l.autor_id, a.nombre AS autor_nombre 
                  FROM " . $this->table . " l 
                  LEFT JOIN autores a ON l.autor_id = a.id 
                  WHERE l.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un libro
    public function actualizarLibro($id, $titulo, $descripcion, $autor_id) {
        $query = "UPDATE " . $this->table . " 
                  SET titulo = :titulo, descripcion = :descripcion, autor_id = :autor_id 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':autor_id', $autor_id);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Obtener todos los autores para el desplegable
    public function obtenerAutores() {
        $query = "SELECT id, nombre FROM autores";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>