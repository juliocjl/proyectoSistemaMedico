<?php
function decrypt_aes($ciphertext, $key, $iv){
        //$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
        
        $cipher = "aes-128-cbc";
        
        if (in_array( $cipher, openssl_get_cipher_methods()) )
        {
            //store $cipher, $iv, and $tag for decryption later
            $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);
            
            return $original_plaintext;
        }
    }
?>