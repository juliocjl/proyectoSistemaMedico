<?php
        include 'conexion.php';

        $usuario = $_POST['usuario'];
        $passLogin = $_POST['passLog'];

        echo "<br /> $usuario : ".$passLogin . "<br />";
        
        //Se verifica primero que no exista un usuario con el mismo correo
        //  Se realiza consulta a tabla de pacientes

        $consultaPaciente = "SELECT * FROM pacientes WHERE correo = '$usuario'";
        $verifica_usuario_paciente = mysqli_query($conexion, $consultaPaciente);
        $filasPacientes = mysqli_num_rows($verifica_usuario_paciente); //Se almacena numero de filas

        //  Se realiza consulta a tabla de personal Medico
        $consultaMedicos = "SELECT * FROM personalmedico WHERE correo = '$usuario'";
        $verifica_usuario_medico = mysqli_query($conexion, $consultaMedicos);
        $filasPM = mysqli_num_rows($verifica_usuario_medico);//Se almacena numero de filas


        if ( $filasPacientes > 0){
            $row = $verifica_usuario_paciente -> fetch_assoc(); //Se almacena toda la fila
            $hash = trim($row['pass']); //Se obtiene el hash  
            if( !(password_verify($passLogin, $hash)) ){ //Se comprueba el hash con la contraseña introducida
                echo "El usuario no existe";
                exit;
            }
            else{//si la comparacion es correcta se ejecuta este bloque
                echo "La contraseña es correcta <br/>";
                session_start();
                echo " El usuario es correcto <br/>";
                $_SESSION['usuario'] = $row['correo'];
                header("location:sesiones/sesionPaciente.php");  
            }
            mysqli_close($conexion); //Se cierra conexion
        }elseif ($filasPM > 0 ) {
            $row = $verifica_usuario_medico -> fetch_assoc();
            $hash = trim($row['pass']);        
            if( !(password_verify($passLogin, $hash)) ){
                echo "El usuario no existe";
                exit;
            }
            else{//Se compara si el personal es medico o de otro tipo
                if($row['tipoPersonal'] == 'Tecnico' || $row['tipoPersonal'] == 'Administrativo' || $row['tipoPersonal'] == 'Otro'){
                    echo "La contraseña es correcta <br/>";
                    session_start();
                    echo " El usuario es correcto <br/>";
                    $_SESSION['usuario'] = $usuario;
                    header("location:sesiones/sesionPS.php"); 
                }else{
                    echo "La contraseña es correcta <br/>";
                    session_start();
                    echo " El usuario es correcto <br/>";
                    $_SESSION['usuario'] = $usuario;
                    header("location:sesiones/sesionPM.php");  
                }
            }
            mysqli_close($conexion); //Se cierra conexion
        }
?>
       
