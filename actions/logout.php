<?php

    include_once ('../includes/session.php');

    if(isset($_SESSION['username'])){
        //$_SESSION['username'] = "";
        //unset($_SESSION['username']);
        session_destroy();
        header('Location: ../pages/homePage.php');
    }

?>