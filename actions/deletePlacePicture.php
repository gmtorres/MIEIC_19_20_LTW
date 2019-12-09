<?php

    include_once ('../includes/database.php');

    $imageId = $_GET['imageId'];

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