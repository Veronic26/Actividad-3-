<?php
require_once 'models/Libro.php';

class LibroController {
    private $libro;

    public function __construct() {
        $this->libro = new Libro();
    }

    public function index() {
        $libros = $this->libro->obtenerLibros();
        $autores = $this->libro->obtenerAutores();
        require_once 'views/libros/index.php';
    }

    public function store() {
        ob_start(); // Evitar salidas accidentales
        header('Content-Type: application/json');
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $autor_id = $_POST['autor_id'] ?? '';
        if (empty($titulo) || empty($autor_id)) {
            echo json_encode(['success' => false, 'message' => 'El título y el autor son requeridos']);
            ob_end_flush();
            exit;
        }
        if ($this->libro->agregarLibro($titulo, $descripcion, $autor_id)) {
            $id = $this->libro->conn->lastInsertId();
            $nuevoLibro = $this->libro->obtenerLibroPorId($id);
            if ($nuevoLibro === false) {
                echo json_encode(['success' => false, 'message' => 'No se pudo obtener el libro recién creado']);
            } else {
                echo json_encode(['success' => true, 'libro' => $nuevoLibro]);
            }
        } else {
            $error = $this->libro->conn->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Error al agregar el libro', 'db_error' => $error]);
        }
        ob_end_flush();
        exit;
    }

    public function update($id) {
        ob_start();
        header('Content-Type: application/json');
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $autor_id = $_POST['autor_id'] ?? '';
        if (empty($titulo) || empty($autor_id)) {
            echo json_encode(['success' => false, 'message' => 'El título y el autor son requeridos']);
            ob_end_flush();
            exit;
        }
        if ($this->libro->actualizarLibro($id, $titulo, $descripcion, $autor_id)) {
            $libroActualizado = $this->libro->obtenerLibroPorId($id);
            if ($libroActualizado === false) {
                echo json_encode(['success' => false, 'message' => 'No se pudo obtener el libro actualizado']);
            } else {
                echo json_encode(['success' => true, 'libro' => $libroActualizado]);
            }
        } else {
            $error = $this->libro->conn->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el libro', 'db_error' => $error]);
        }
        ob_end_flush();
        exit;
    }

    public function delete($id) {
        header('Content-Type: application/json');
        if ($this->libro->eliminarLibro($id)) {
            echo json_encode(['success' => true, 'id' => $id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el libro']);
        }
        exit;
    }
}
?>
