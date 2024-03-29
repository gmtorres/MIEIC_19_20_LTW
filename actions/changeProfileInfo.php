<?php

    include_once ('../includes/database.php');
    include_once ('../includes/session.php');

    checkCSRF();

    if(isset($_POST['function'])){    
        $function = $_POST['function'];

        if($function == 'changeUserName'){
            $value = changeUserName(validate_input($_POST['username']));         
        }
        else if($function == 'changePassword'){
            $value = changePassword(validate_input($_POST['old']),validate_input($_POST['new']));      
        }
        else if($function == 'changeEmail'){
            $value = changeEmail(validate_input($_POST['old']),validate_input($_POST['new']));      
        }
        echo $value;
        exit;
    }

    function changeUserName($username){

        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from User where userName = :username');
        $stmt->bindParam(':username',$username);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user !== FALSE){
            return json_encode(["ret" => 0,"message" => "Username already exists, try another one"]);
        }

        $stmt = $db->prepare('Update User set userName = ? where userId = ?');
        $stmt->execute(array($username,$_SESSION['userId']));

        return json_encode(["ret" => 1,"message" => "Username changed with sucess"]);
    }

    function changePassword($old,$new){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from User where userId = :userId');
        $stmt->bindParam(':userId',$_SESSION['userId']);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user == FALSE || !password_verify($old, $user['passHash'])){
            return json_encode(["ret" => 0,"message" => "Invalid password"]);
        }

        $stmt = $db->prepare('Update User set passHash = ? where userId = ?');
        $stmt->execute(array(password_hash($new,PASSWORD_DEFAULT),$_SESSION['userId']));

        return json_encode(["ret" => 1,"message" => "New password set with sucess"]);
    }

    function changeEmail($old,$new){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from User where userId = :userId');
        $stmt->bindParam(':userId',$_SESSION['userId']);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user == FALSE || $old != $user['email']){
            return json_encode(["ret" => 0,"message" => "Old email is incorrect"]);
        }

        $stmt = $db->prepare('Update User set email = ? where userId = ?');
        $stmt->execute(array($new,$_SESSION['userId']));

        return json_encode(["ret" => 1,"message" => "New email set with sucess"]);
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>