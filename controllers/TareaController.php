<?php

require_once 'models/TareaModel.php';
require_once 'config/Database.php';

class TareaController {
    private $db;
    private $tareaModel;



    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->tareaModel = new TareaModel($this->db);
    }


    //mostrar todas las tareas
    public function index (){
        $tareas = $this->tareaModel->leer();
        include 'views/home.php';
    }

    public function crear(){
        include 'views/crear.php';
    }

    public function guardar() {
        if ($_POST) {
            $titilo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            if ($this->tareaModel->crear($titilo, $descripcion)) {
                header("Location: index.php");
            } else {
                echo "Error al crear la tarea.";
            }
        }
    }


    //mostrar la informacion de una tarea
    public function editar() {
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
    
}


?>