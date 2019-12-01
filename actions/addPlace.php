<?php

    include_once ('../includes/session.php');

    $db = new PDO('sqlite:../database.db');

    $title = $_POST['Title'];
    $zone = $_POST['Zone'];
    $address = $_POST['Address'];
    $description = $_POST['Description'];
    $maxGuests = $_POST['maxGuests'];
    $placeOwner = $_SESSION['userID'];

    $extras = json_decode($_POST['extrasInput']);
    $restrictions = json_decode($_POST['restrictionsInput']);


    try{
        $stmt = $db->prepare('Insert into 
                Place(title,placeDescription,placeAddress,city,maxGuests,placeOwner) 
                                values (?,?,?,?,?,?)');
        $stmt->execute(array($title,$description,$address,$zone,$maxGuests,$placeOwner));

        $stmt = $db->prepare('Select placeId from Place where title = ? and placeOwner = ? and placeDescription = ?');
        $stmt->execute(array($title,$placeOwner,$description));
        $placeId = $stmt->fetch();

        foreach($extras as $extra){
            $stmt = $db->prepare('Insert into ExtraAmenities(amenitiesDescription,PlaceId) values(?,?)');
            $stmt->execute(array($extra,$placeId['placeID']));
        }
        foreach($restrictions as $restriction){
            $stmt = $db->prepare('Insert into ExtraRestrictions(restrictionDescription,PlaceId) values(?,?)');
            $stmt->execute(array($restriction,$placeId['placeID']));
        }

        header('Location: ../pages/house.php?id='. $placeId['placeID']);
    }
    catch (PDOException $e) {
        die($e->getMessage());
        $_SESSION['error'] = "Failed to add a place try again.";
        //$_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
        header('Location: ../pages/addPlace.php');
    }

?>