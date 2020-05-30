<?php
    //se conecta con la base de datos
    $conexion= mysqli_connect('localhost','sistema','sistemaMedico@c', sistemamedico);
    						// direccion,  usuario,    contraseña,     base de datos
        if ($conexion->connect_error){
            echo "No se puede conectar";
        }else
            echo "conectado correctamente";
?>