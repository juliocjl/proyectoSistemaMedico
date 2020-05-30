<?php
    include 'conexion.php';// conexion a la BD
    include 'c_aes.php';// Contiene la funcion para cifrar los datos, se usa AES-128-CBC

    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    //Se genera el vector de inicializacion, para guardarlo en la BD
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));

    /****  Se cifran todos los datos sensibles  ****/
    $nombre_c = encrypt_aes($_POST["nombre"], $pass, $iv);    
    $apellido1_c = encrypt_aes($_POST['apellido1'], $pass, $iv);
    $apellido2_c = encrypt_aes($_POST['apellido2'], $pass, $iv);
    
    $sexo_c = encrypt_aes($_POST['sexo'],$pass, $iv);
    $direccion_c = encrypt_aes($_POST['direccion'], $pass, $iv);
    $cp_c = encrypt_aes($_POST['cp'], $pass, $iv);
    $telefono_c = encrypt_aes($_POST['telefono'], $pass, $iv);
    $curp_c = encrypt_aes($_POST['curp'],$pass, $iv);
    $rfc_c = encrypt_aes($_POST['rfc'],$pass, $iv);
    $nss_c = encrypt_aes($_POST['nss'],$pass, $iv);
    
    $estado_c = encrypt_aes($_POST['estado'],$pass, $iv);
    $hijos_c = encrypt_aes($_POST['hijos'],$pass, $iv);
    $lugar_c = encrypt_aes($_POST['lugar'],$pass, $iv);
    $drogas_c = encrypt_aes($_POST['drogas'],$pass, $iv);
    $medicamentos_c = encrypt_aes($_POST['medicamentos'],$pass, $iv);
    $sanguineo_c = encrypt_aes($_POST['sanguineo'],$pass, $iv);
    $alergias_c = encrypt_aes($_POST['alergias'],$pass, $iv);

    $malestar_c = encrypt_aes($_POST['malestar'],$pass, $iv);
    $padecimiento_c = encrypt_aes($_POST['padecimiento'],$pass, $iv);
    $padecimientoFamiliar_c = encrypt_aes($_POST['padecimientoFamiliar'],$pass, $iv);
    $area_c = encrypt_aes($_POST['area'],$pass, $iv);
    $tratamiento_c = encrypt_aes($_POST['tratamiento'],$pass, $iv);
    
    $edad = $_POST['edad'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $fecha = $_POST['fecha'];


 //Se verifica primero que no exista un usuario con el mismo correo
    $verifica_usuario = mysqli_query($conexion, "SELECT * FROM pacientes WHERE correo = '$correo'");
    $row = $verifica_usuario -> fetch_assoc();
    if ( mysqli_num_rows($verifica_usuario) > 0){
        echo "El usuario ya existe en el registro";
        exit;
    }else{
        //Se obtiene el hash la contraseña con "password_hash"
        $passCifrado = password_hash($pass, PASSWORD_DEFAULT);

        //  Se insertan los datos cifrados del formulario en la base de datos
        $comando="INSERT INTO pacientes(nombre, apellidoP, apellidoM, correo, pass, genero, direccion, 
                                        cp, telefono, curp, rfc, nss, edad, edoCivil, numHijos, lugarNac, 
                                        drogas, medicacion, sanguineo, alergias, altura, peso, malestar, 
                                        enfermedades, parientesEnf, area, tratamiento, fecha, iv) 
                                 VALUES('$nombre_c', '$apellido1_c', '$apellido2_c', '$correo', 
                                        '$passCifrado', '$sexo_c', '$direccion_c','$cp_c', '$telefono_c', 
                                        '$curp_c', '$rfc_c', '$nss_c', '$edad', '$estado_c', '$hijos_c', 
                                        '$lugar_c', '$drogas_c', '$medicamentos_c', '$sanguineo_c', 
                                        '$alergias_c', '$altura','$peso', '$malestar_c','$padecimiento_c', 
                                        '$padecimientoFamiliar_c', '$area_c','$tratamiento_c', '$fecha', '$iv')";

        $ejecutar = mysqli_query($conexion, $comando); //Se ejecuta la operacion.

        if (!$ejecutar) {
            echo "Error al guardar datos";
        } else{
            echo '<script> alert("datos guardados correctamente"); <script/>';
            header("location:../../../index.html"); 
        }
    }

    mysqli_close($conexion); //Se cierra conexion
?>
