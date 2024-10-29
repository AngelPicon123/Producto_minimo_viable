<?php

class Login
{
    private $conn;
    private $table_name = "login";

    public $id_usuario;
    public $username;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

        return $stmt->execute();
    }
    public function read()
    {
        $query = "SELECT id_usuario, username, password FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id_usuario = $row['id_usuario'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            return true;
        }
        return false;
    }
}
?>