<?php

    include_once ('../includes/session.php');

    $db = new PDO('sqlite:../database.db');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare('Select * from User where userName = :username');
    $stmt->bindParam(':username',$username);
    $stmt->execute();
    $user = $stmt->fetch();

    //if($user !== false && password_verify($password , $user['password'])){
    if($user !== false && password_verify($password, $user['passHash'])){
        $_SESSION['username'] = $username;
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['login_message'] = "Sucessful login.";

        if(isset($_SESSION['redirect'])){
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header('Location: ' . $redirect);
        }else
            header('Location: ../pages/homePage.php');
    }else{
        $_SESSION['login_message'] = "Wrong username or password, try again."; 
        header('Location: ../pages/login.php');
    }
?>