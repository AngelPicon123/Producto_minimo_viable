<?php

require_once '../src/config/DataBse.php';

$database= new DataBse();

$conn = $database->getConnection();

    if($conn)
    {
        echo "Conectado correctamente a la base de datos";
    }
    else
    {
        echo "Error al conectar a la base de datos";
    }