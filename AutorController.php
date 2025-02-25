<?php
require_once 'models/Autor.php';

class AutorController {
    private $autor;

    public function __construct() {
        $this->autor = new Autor();
    }

    public function index() {
        $autores = $this->autor->obtenerAutores();
        require_once 'views/autores/index.php';
    }

    public function store() {
        header('Content-Type: application/json');
        $nombre = $_POST['nombre'] ?? '';
        if (empty($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
            exit;
        }
        if ($this->autor->agregarAutor($nombre)) { // Quité el '' extra
            $id = $this->autor->conn->lastInsertId();
            $nuevoAutor = $this->autor->obtenerAutorPorId($id);
            if ($nuevoAutor === false) {
                echo json_encode(['success' => false, 'message' => 'No se pudo obtener el autor recién creado']);
            } else {
                echo json_encode(['success' => true, 'autor' => $nuevoAutor]);
            }
        } else {
            $error = $this->autor->conn->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Error al agregar el autor', 'db_error' => $error]);
        }
        exit;
    }

    public function update($id) {
        header('Content-Type: application/json');
        $nombre = $_POST['nombre'] ?? '';
        if (empty($nombre)) {
            echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
            exit;
        }
        if ($this->autor->actualizarAutor($id, $nombre)) {
            $autorActualizado = $this->autor->obtenerAutorPorId($id);
            echo json_encode(['success' => true, 'autor' => $autorActualizado]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el autor']);
        }
        exit;
    }

    public function delete($id) {
        header('Content-Type: application/json');
        if ($this->autor->eliminarAutor($id)) {
            echo json_encode(['success' => true, 'id' => $id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el autor']);
        }
        exit;
    }
}
?>