<?php

require_once __DIR__ . '/../model/TerapeutaModel.php';
require_once __DIR__ . '/../config/DataBase.php';

class TerapeutaController
{
    private $db;
    private $model;

    public function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConnection();
        $this->model = new TerapeutaModel($this->db);
    }

    // BUSCAR TODOS LOS TERAPEUTAS
    public function getAllTerapeutas()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $terapeutas = $this->model->getAllTerapeutas();
        echo json_encode($terapeutas);
    }

    // BUSCAR TERAPEUTA POR ID
    public function getTerapeutaById($id_terapeuta)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        if (!empty($id_terapeuta)) {
            $terapeuta = $this->model->getTerapeutaById($id_terapeuta);

            if ($terapeuta) {
                echo json_encode($terapeuta);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Terapeuta no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }

    // BUSCAR TERAPEUTA POR DNI
    public function getTerapeutaByDni($dni_terapeuta)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        if (!empty($dni_terapeuta)) {
            $terapeuta = $this->model->getTerapeutaByDni($dni_terapeuta);

            if ($terapeuta) {
                echo json_encode($terapeuta);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Terapeuta no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }

    // CREAR NUEVO TERAPEUTA
    public function createTerapeuta()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (

            !empty($data->dni_terapeuta) && !empty($data->nombre) && !empty($data->apellido) && !empty($data->correo) &&
            !empty($data->direccion) && !empty($data->provincia) && !empty($data->region) && !empty($data->sexo) && !empty($data->nroTelefonico)
        ) {
            // Insertar el nuevo terapeuta en la base de datos
            $result = $this->model->createTerapeuta(
                $data->dni_terapeuta,
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
                echo json_encode(["message" => "Terapeuta creado exitosamente"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Fallo al crear terapeuta"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida, faltan datos"]);
        }
    }

    // ACTUALIZAR UN TERAPEUTA
    public function updateTerapeuta($id_terapeuta)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nombre) && !empty($data->apellido) && !empty($data->correo) &&
            !empty($data->direccion) && !empty($data->provincia) && !empty($data->region) &&
            !empty($data->dni) && !empty($data->sexo) && !empty($data->nroTelefonico)
        ) {

            $updated = $this->model->updateTerapeuta(
                $id_terapeuta,
                $data->dni_terapeuta,
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
                echo json_encode(["message" => "Terapeuta actualizado correctamente"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Terapeuta no se actualizó"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Entrada inválida"]);
        }
    }

    // ELIMINAR UN TERAPEUTA
    public function deleteTerapeuta($id_terapeuta)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: DELETE");

        if ($this->model->deleteTerapeuta($id_terapeuta)) {
            echo json_encode(["message" => "Terapeuta eliminado con éxito."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "El terapeuta no pudo ser eliminado o no se encontró."]);
        }
    }
}
