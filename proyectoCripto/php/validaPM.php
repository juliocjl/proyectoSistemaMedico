<?php
    include 'conexion.php';// conexion a la BD
    include 'c_aes.php';// Contiene la funcion para cifrar los datos, se usa AES-128-CBC


    $correo=$_POST['correo'];
    $pass=$_POST['pass'];

    //Se genera el vector de inicializacion, para guardarlo en la BD
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));

    /****   Se cifran todos los datos sensibles    ****/
    $nombre = encrypt_aes($_POST["nombre"], $pass, $iv);
    $apellido1 = encrypt_aes($_POST['apellido1'], $pass, $iv);
    $apellido2 = encrypt_aes($_POST['apellido2'], $pass, $iv);
    $tipoPersonal = encrypt_aes($_POST['tipoPersonal'], $pass, $iv);
    $direccion = encrypt_aes($_POST['direccion'], $pass, $iv);
    $cp = encrypt_aes($_POST['cp'], $pass, $iv);
    $telefono = encrypt_aes($_POST['telefono'], $pass, $iv);
    $curp = encrypt_aes($_POST['curp'], $pass, $iv);
    $rfc = encrypt_aes($_POST['rfc'], $pass, $iv);
    $area = encrypt_aes($_POST['area'], $pass, $iv);

 //Se verifica primero que no exista un usuario con la misma curp y correo
    $verifica_usuario = mysqli_query($conexion, "SELECT * FROM pacientes WHERE correo = '$correo'");
    if ( mysqli_num_rows($verifica_usuario) > 0){
        echo "El usuario ya existe en el registro";
        exit;
    }else{
        /* Se obtiene el Hash de la contraseña */
        $passCifrado = password_hash($pass, PASSWORD_DEFAULT);

        /*  Se insertan los datos cifrados en la base de datos */ 
        $comando="INSERT INTO personalmedico(nombre, apellidoP, apellidoM, correo, pass, 
                                            tipoPersonal, direccion, cp, telefono, curp, rfc, area, iv) 
                            VALUES('$nombre','$apellido1', '$apellido2', '$correo', '$passCifrado', 
                            '$tipoPersonal', '$direccion','$cp', '$telefono', '$curp', '$rfc', '$area', '$iv')";

        $ejecutar = mysqli_query($conexion, $comando);

        if (!$ejecutar) {
            echo "Error al guardar datos";
        } else{
            echo '<script> alert("datos guardados correctamente"); <script/>';
            
            header("location:../../../index.html"); 
        }
    }

    mysqli_close($conexion); //Se cierra conexion

?>
