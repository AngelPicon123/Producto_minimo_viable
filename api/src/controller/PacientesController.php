<?php

require_once __DIR__ . '/../models/PacienteModel.php';
require_once __DIR__ . '/../config/DataBase.php';

class PacientesController
{
    private $db;
    private $model;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnection();
        $this->model = new PacienteModel($this->db);
    }

    public function getAllPacientes()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $pacientes = $this->model->getAllPacientes();
        echo json_encode($pacientes);
    }

    public function findByIdPaciente()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id_paciente)) {
            $paciente = $this->model->findByIdPaciente($data->id_paciente);

            if ($paciente) {
                echo json_encode($paciente);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Paciente no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }

    public function createPaciente()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->dni_paciente) && !empty($data->nombre) && !empty($data->apellido) &&
            !empty($data->correo) && !empty($data->direccion) && !empty($data->provincia) &&
            !empty($data->region) && !empty($data->sexo) && !empty($data->nroTelefonico)
        ) {

            $result = $this->model->createPaciente(
                $data->dni_paciente,
                $data->nombre,
                $data->apellido,
                $data->correo,
                $data->direccion,
                $data->provincia,
                $data->region,
                $data->sexo,
                $data->nroTelefonico
            );

            if ($result) {
                echo json_encode(["message" => "Paciente creado con éxito"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Error al crear el paciente"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }


    public function updatePaciente($id_paciente)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->dni_paciente) && !empty($data->nombre) && !empty($data->apellido) &&
            !empty($data->correo) && !empty($data->direccion) && !empty($data->provincia) &&
            !empty($data->region) && !empty($data->sexo) && !empty($data->nroTelefonico)
        ) {

            $updated = $this->model->updatePaciente(
                $id_paciente,
                $data->dni_paciente,
                $data->nombre,
                $data->apellido,
                $data->correo,
                $data->direccion,
                $data->provincia,
                $data->region,
                $data->sexo,
                $data->nroTelefonico
            );

            if ($updated) {
                echo json_encode(["message" => "Paciente actualizado con éxito"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Paciente no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }


    public function deletePaciente($id_paciente)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: DELETE");

        if ($this->model->deletePaciente($id_paciente)) {
            echo json_encode(["message" => "Paciente eliminado con éxito"]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No se pudo eliminar el paciente"]);
        }
    }
}