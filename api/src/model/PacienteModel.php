<?php
// Modelo de los pacientes registrados en la base de datos
class PacienteModel {
    private $conn;
    private $table_name = "pacientes";

    public function __construct($database) {
        $this->conn = $database;
    }

//crear pacientes
public function crearPaciente($dni_paciente, $nombre, $apellido, $correo, $direccion, $provincia, $region, $sexo, $nroTelefonico) {
    $sql = "INSERT INTO " . $this->table_name . " (dni_paciente, nombre, apellido, correo, direccion, provincia, region, sexo, nroTelefonico) 
            VALUES (:dni_paciente, :nombre, :apellido, :correo, :direccion, :provincia, :region, :sexo, :nroTelefonico)";
    $stmt = $this->conn->prepare($sql);

    // Vincular parámetros
    $stmt->bindParam(':dni_paciente', $dni_paciente);
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

// Obtener todos los pacientes
public function obtenerPacientes() {
    $query = "SELECT id_paciente, dni_paciente, nombre, apellido, correo, direccion, provincia, region, sexo, nroTelefonico 
              FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Obtener paciente por ID
public function obtenerPacientePorId($id_paciente) {
    $sql = "SELECT id_paciente, dni_paciente, nombre, apellido, correo, direccion, provincia, region, sexo, nroTelefonico 
            FROM " . $this->table_name . " 
            WHERE id_paciente = :id_paciente";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Actualizar paciente
public function actualizarPaciente($id_paciente, $dni_paciente, $nombre, $apellido, $correo, $direccion, $provincia, $region, $sexo, $nroTelefonico) {
    $sql = "UPDATE " . $this->table_name . " 
            SET dni_paciente = :dni_paciente, 
                nombre = :nombre, 
                apellido = :apellido, 
                correo = :correo, 
                direccion = :direccion, 
                provincia = :provincia, 
                region = :region, 
                sexo = :sexo, 
                nroTelefonico = :nroTelefonico 
            WHERE id_paciente = :id_paciente";
    $stmt = $this->conn->prepare($sql);

    // Vincular parámetros
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->bindParam(':dni_paciente', $dni_paciente);
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


// Eliminar paciente
public function eliminarPacientePorId($id_paciente) {
    $sql = "DELETE FROM " . $this->table_name . " WHERE id_paciente = :id_paciente";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}
