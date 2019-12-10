<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $db = Database::instance()->db();

    $username = validate_input($_POST['username']);
    $password = validate_input($_POST['password']);
    $phoneNumber = validate_input($_POST['phoneNumber']);
    $email = validate_input($_POST['email']);
    $age = validate_input($_POST['age']);

    if(strlen((string)$phoneNumber) !==  9){
        $_SESSION['register_message'] = "Phone number must be 9 digits.";

        header('Location: ../pages/register.php');
        exit;
    }

    $stmt1 = $db->prepare('Select userName from User where username = :username');
    $stmt1->bindParam(':username',$username);
    $stmt1->execute();
    $user1 = $stmt1->fetch();

    $stmt2 = $db->prepare('Select userName from User where email = :email');
    $stmt2->bindParam(':email',$email);
    $stmt2->execute();
    $user2 = $stmt2->fetch();

    if($user1 !== FALSE || $user2 !== FALSE){
        if($user1 !== FALSE)
            $_SESSION['register_message'] = "User already exists, try another one.";
        else if($userw !== FALSE)
            $_SESSION['register_message'] = "Email already in use, try another one.";

        header('Location: ../pages/homePage.php');
    }else{

        try{
            $stmt = $db->prepare('Insert into 
                                    User(userName,email,passHash,age,phoneNumber) 
                                    values (?,?,?,?,?)');
            $stmt->execute(array($username,$email,password_hash($password,PASSWORD_DEFAULT),$age,$phoneNumber));
            
            $_SESSION['username'] = $username;

            $stmt3 = $db->prepare('Select * from User 
                                    where userName = :username
                                ');
            $stmt3->bindParam(':username', $username);
            $stmt3->execute();
            $userId = $stmt3->fetch();

            $_SESSION['userId'] = $userId['userID'];

            //print_r($userId);

            header('Location: ../actions/register_getId.php');
        }
        catch (PDOException $e) {
            die($e->getMessage());
            $_SESSION['register_message'] = "Failed to register try again.";
            //$_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
            header('Location: ../pages/homePage.php');
        }
    }


    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>