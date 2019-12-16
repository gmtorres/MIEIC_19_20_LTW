<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $db = Database::instance()->db();

    checkCSRF();

    $title = validate_input($_POST['Title']);
    $zone = validate_input($_POST['Zone']);
    $address = validate_input($_POST['Address']);
    $description = validate_input($_POST['Description']);
    $maxGuests = validate_input($_POST['maxGuests']);
    $placeOwner = validate_input($_SESSION['userId']);

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
            $stmt->execute(array(validate_input($extra),$placeId['placeID']));
        }
        foreach($restrictions as $restriction){
            $stmt = $db->prepare('Insert into ExtraRestrictions(restrictionDescription,PlaceId) values(?,?)');
            $stmt->execute(array(validate_input($restriction),$placeId['placeID']));
        }

        header('Location: ../pages/house.php?id='. $placeId['placeID']);
    }
    catch (PDOException $e) {
        die($e->getMessage());
        $_SESSION['error'] = "Failed to add a place try again.";
        //$_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
        header('Location: ../pages/addPlace.php');
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>