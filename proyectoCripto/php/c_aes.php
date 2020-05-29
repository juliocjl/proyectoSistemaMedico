<?php
function encrypt_aes($plaintext, $key, $iv){
        //$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
        
        $cipher = "aes-128-cbc";
        
        if (in_array( $cipher, openssl_get_cipher_methods()) )
        {
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv);
            //store $cipher, $iv, and $tag for decryption later
    
            return $ciphertext;
        }
    }
?>
