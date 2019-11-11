<?php


    include_once ('../includes/session.php');

    $db = new PDO('sqlite:../database.db');

    $title = $_POST['Title'];
    $zone = $_POST['Zone'];
    $address = $_POST['Address'];
    $description = $_POST['Description'];
    $maxGuests = $_POST['maxGuests'];
    $placeOwner = $_SESSION['userID'];


    try{
        $stmt = $db->prepare('Insert into 
                Place(title,placeDescription,placeAddress,area,maxGuests,placeOwner) 
                                values (?,?,?,?,?,?)');
        $stmt->execute(array($title,$description,$address,$zone,$maxGuests,$placeOwner));

        header('Location: ../pages/user.php');
    }
    catch (PDOException $e) {
        die($e->getMessage());
        $_SESSION['error'] = "Failed to add a place try again.";
        //$_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
        header('Location: ../pages/addPlace.php');
    }


?>