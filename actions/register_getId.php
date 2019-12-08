<?php

    /*

            $stmt3 = $db->prepare('Select * from User 
                            ');
            //$stmt3->bindParam('userName' , $username);
            $stmt3->execute();
            $userId = $stmt3->fetchAll();

            $_SESSION['userId'] = $userId['Id'];

            print_r($userId);
    */

    include_once ('./actions/getUserInfo.php');
    //echo getUserID('Gustavo');

    header('Location: ../pages/homePage.php');
?>