<?php

require_once '../src/config/DataBase.php';

$database = new DataBase();

$conn = $database->getConnection();

if ($conn) {
    echo "Conectado correctamente a la base de datos";
} else {
    echo "Error al conectar a la base de datos";
}