<?php

function conectarDB() : mysqli  {
    $db = mysqli_connect('localhost:3307', 'root',  '', 'DBSys');

    if(!$db) {
        echo "Error, no se pudo conectar";

        exit;
    } 

    return $db;
}

?>