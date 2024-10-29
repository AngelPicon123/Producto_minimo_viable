<?php
// Modelo de los terapeutas registrados en la base de datos
class TerapeutaModel
{
    private $conn;
    private $table_name = "terapeuta";

    public function __construct($database)
    {
        $this->conn = $database;
    }

    // Crear Terapeuta
    public function createTerapeuta($dni_terapeuta, $nombre, $apellido, $correo, $direccion, $provincia, $region, $sexo, $nroTelefonico)
    {
        $sql = "INSERT INTO " . $this->table_name . " 
            (dni_terapeuta, nombre, apellido, correo, direccion, provincia, region, sexo, nroTelefonico) 
            VALUES (:dni_terapeuta, :nombre, :apellido, :correo, :direccion, :provincia, :region, :sexo, :nroTelefonico)";
        $stmt = $this->conn->prepare($sql);

        // Vincular parámetros
        $stmt->bindParam(':dni', $dni_terapeuta);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':nroTelefonico', $nroTelefonico);

        // Ejecutar la consulta
        return $stmt->execute();
    }

    // Buscar todos los terapeutas
    public function getAllTerapeutas()
    {
        $query = "SELECT id_terapeuta, dni_terapeuta, nombre, apellido, correo, direccion, provincia, region, sexo, nroTelefonico FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // BUSCAR TERAPEUTA POR ID
    public function getTerapeutaById($id_terapeuta)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_terapeuta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_terapeuta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar terapeuta por DNI
    public function getTerapeutaByDni($dni_terapeuta)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE dni_terapeuta = :dni_terapeuta";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':dni', $dni_terapeuta);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar Terapeuta
    public function updateTerapeuta($id_terapeuta, $dni_terapeuta, $nombre, $apellido, $correo, $direccion, $provincia, $region, $sexo, $nroTelefonico)
    {
        $sql = "UPDATE " . $this->table_name . " SET dni_terapeuta = :dni_terapeuta, nombre = :nombre, apellido = :apellido, correo = :correo, 
                direccion = :direccion, provincia = :provincia, region = :region, sexo = :sexo, 
                nroTelefonico = :nroTelefonico WHERE id_terapeuta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':dni', $dni_terapeuta);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':provincia', $provincia);
        $stmt->bindParam(':region', $region);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':nroTelefonico', $nroTelefonico);
        $stmt->bindParam(':id', $id_terapeuta, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Eliminar Terapeuta
    public function deleteTerapeuta($id_terapeuta)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id_terapeuta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_terapeuta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
