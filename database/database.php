<?php

    $host ='localhost';
    $user = 'root';
    $password = '';
    $db = 'photopostbd';

    $conection = @mysqli_connect($host, $user, $password, $db);

    if(!$conection){
        echo "Error al conectar";
    }
?>