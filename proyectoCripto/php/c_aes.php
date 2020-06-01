<?php
function encrypt_aes($plaintext, $key, $iv){
        
        $cipher = "aes-128-cbc"; //tipo de cifrado utilizado
        
        if (in_array( $cipher, openssl_get_cipher_methods()) ){
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv);
            //el vector de inicializacion se genera al momento de registrar al usuario
            return $ciphertext; //Se regresa una cadena cifrada.
        }
    }
?>
