<?php

    include_once ('../includes/session.php');

    $db = new PDO('sqlite:../database.db');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare('Select * from User where userName = :username');
    $stmt->bindParam(':username',$username);
    $stmt->execute();
    $user = $stmt->fetch();

    ?>
            <h1>olf</h1>
        <?php

    //if($user !== false && password_verify($password , $user['password'])){
    if($user !== false && $password == $user['passHash']){
        $_SESSION['username'] = $username;
        header('Location: ../pages/homePage.php');
    }else{
        header('Location: ../pages/login.php');
    }


?>