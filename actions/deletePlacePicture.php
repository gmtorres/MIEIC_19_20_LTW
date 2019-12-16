<?php

    include_once ('../includes/database.php');
    include_once ('../includes/session.php');
    include_once ('../actions/generalChecks.php');


    $imageId = $_GET['imageId'];

    if(!isPicFromUser($_SESSION['userId'],$imageId)){
        echo json_encode(['error' => 'do not match']);
        exit;
    }

    $db = Database::instance()->db();

    $stmt = $db->prepare('Select * from PlaceImage where placeImageID = ?');
    $stmt->execute(array($imageId));
    $image = $stmt->fetch();
    
    $path = $image['imagePath'];

    $stmt = $db->prepare('Delete from PlaceImage where placeImageID = ?');
    $stmt->execute(array($imageId));

    if(file_exists("$path"))
        unlink("$path");
    
    echo json_encode(['imageId' => $imageId]);
?>