<?php
include_once '../config/Database.php';
include_once '../models/Login.php';

class LoginController
{
    private $db;
    private $login;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->login = new Login($this->db);
    }
    public function create($username, $password)
    {
        $this->login->username = $username;
        $this->login->password = password_hash($password, PASSWORD_BCRYPT);

        if ($this->login->create()) {
            return json_encode(["message" => "Usuario creado correctamente."]);
        } else {
            return json_encode(["message" => "Error al crear el usuario."]);
        }
    }
    public function read($username)
    {
        $this->login->username = $username;

        if ($this->login->read()) {
            return json_encode([
                "id_usuario" => $this->login->id_usuario,
                "username" => $this->login->username
            ]);
        } else {
            return json_encode(["message" => "Usuario no encontrado."]);
        }
    }
}
?>