<?php
require_once 'models/TareaModel.php';
require_once 'config/Database.php';

class TareaController
{
    private $db;
    private $tareaModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tareaModel = new TareaModel($this->db);
    }

    // Mostrar todas las tareas
    public function index()
    {
        $tareas = $this->tareaModel->leer();
        include 'views/home.php';
    }

    // Crear la tarea
    public function crear()
    {
        include 'views/crear.php';
    }

    // Guardar tarea
    public function guardar()
    {
        if ($_POST) {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];

            if ($this->tareaModel->crear($titulo, $descripcion)) {
                header("Location: index.php");
            } else {
                echo "Error al crear la tarea.";
            }
        }
    }

    // Mostrar la información en el formulario
    public function editar()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $tarea = $this->tareaModel->leerUno($id);

            if ($tarea) {
                include 'views/editar.php';
            } else {
                echo "Tarea no encontrada.";
            }
        }
    }

    // Actualizar tarea
    public function actualizar()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];

            if ($this->tareaModel->actualizar($id, $titulo, $descripcion)) {
                header("Location: index.php");
            } else {
                echo "Error al actualizar la tarea.";
            }
        }
    }


    // Eliminar tarea
    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->tareaModel->eliminar($id)) {
                header("Location: index.php");
            } else {
                echo "Error al eliminar la tarea.";
            }
        }
    }
}
