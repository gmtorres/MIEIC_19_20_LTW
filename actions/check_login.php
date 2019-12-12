<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $db = Database::instance()->db();

    $username = validate_input($_POST['username']);
    $password = validate_input($_POST['password']);

    $stmt = $db->prepare('Select * from User where userName = :username');
    $stmt->bindParam(':username',$username);
    $stmt->execute();
    $user = $stmt->fetch();

    //if($user !== false && password_verify($password , $user['password'])){
    if($user !== false && password_verify($password, $user['passHash'])){
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $user['userID'];
        $_SESSION['login_message'] = "Sucessful login.";

        if(isset($_SESSION['redirect'])){
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header('Location: ' . $redirect);
        }else
            header('Location: ../pages/login.php');
    }else{
        $_SESSION['login_message'] = "Wrong username or password, try again."; 
        header('Location: ../pages/login.php');
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>