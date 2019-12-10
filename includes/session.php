<?php

    session_start();
    session_regenerate_id(true);
    

    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = generate_random_token();
    }
    
    
    function generate_random_token() {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    function checkCSRF(){
        if ( !isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']) {
            echo json_encode(["ret" => 0,"message" => "Error"]);
            exit;   
        }
    }


?>