<?php
class TareaModel {
    private $conn;
    private $table_name = "tareas";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Leer tareas
    public function leer() {
        $query = "SELECT id, titulo, descripcion, fecha_creacion FROM " . $this->table_name . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Crear tarea
    public function crear($titulo, $descripcion) {
        $query = "INSERT INTO " . $this->table_name . " SET titulo = :titulo, descripcion = :descripcion";
        $stmt = $this->conn->prepare($query);

        $titulo = htmlspecialchars(strip_tags($titulo));
        $descripcion = htmlspecialchars(strip_tags($descripcion));

        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer una tarea
    public function leerUno($id) {
        $query = "SELECT titulo, descripcion FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            return $row;
        }
        return null;
    }
}