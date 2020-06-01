<?php
function decrypt_aes($ciphertext, $key, $iv){
        
        $cipher = "aes-128-cbc"; //tipo de cifrado utilizado
        
        if (in_array( $cipher, openssl_get_cipher_methods()) ){
            //el vector de inicializacion se genera al momento de registrar al usuario
            $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);
            return $original_plaintext; //Se regresa una cadena decifrada.
        }
    }
?>