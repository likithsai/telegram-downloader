<?php

    error_reporting(E_ERROR | E_PARSE);

    class crypt {
        protected $encrypt_method = 'AES-256-CBC';
        private $key;


        public function encrypt ( $string ) {
            $new_iv = bin2hex ( random_bytes ( openssl_cipher_iv_length ( $this->encrypt_method ) ) );
            $encrypted = base64_encode ( openssl_encrypt ( $string, $this->encrypt_method, $this->key, 0, $new_iv ) );

            return $new_iv.':'.$encrypted;
        }

        

        public function decrypt ( $string ) {
            $parts = explode(':', $string );
            $iv = $parts[0];
            $encrypted = $parts[1];
            
            if ( $decrypted = openssl_decrypt ( base64_decode ( $encrypted ), $this->encrypt_method, $this->key, 0, $iv ) ) {
                return $decrypted;
            } else {
                return false;
            }
        }

        

    }
?>