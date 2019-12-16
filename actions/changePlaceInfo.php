<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/generalChecks.php');
    
    $db = Database::instance()->db();

    checkCSRF();

    $title = validate_input($_POST['Title']);
    $zone = validate_input($_POST['Zone']);
    $address = validate_input($_POST['Address']);
    $description = validate_input($_POST['Description']);
    $maxGuests = validate_input($_POST['maxGuests']);
    $placeOwner = validate_input($_SESSION['userId']);
    $placeId = $_SESSION['placeManaging'];

    if(!isPlaceFromUser($_SESSION['userId'],$placeId)){
        echo json_encode(['error' => 'do not match']);
        exit;
    }

    $stmt = $db->prepare('Update Place set title = ? , city = ? , placeAddress = ?, placeDescription = ?, maxGuests = ? where placeId = ?');
    $stmt->execute(array($title,$zone,$address,$description,$maxGuests,$placeId));
    
    header("Location: ../pages/houseManage.php?id=".$placeId);


    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>