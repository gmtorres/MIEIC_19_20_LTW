<?php

    include_once ('../includes/database.php');
    include_once ('../includes/session.php');
    include_once ('../actions/generalChecks.php');

    $rentId = $_GET['rentId'];
    $state = $_GET['state'];

    if(!isRentFromUser($_SESSION['userId'],$rentId)){
        echo json_encode(['error' => 'do not match']);
        exit;
    }

    if($state == -3){
        
    }

    $db = Database::instance()->db();
    $stmt = $db->prepare('Update Rent set accepted = :state where rentId = :rentId');
    $stmt->bindParam(':rentId', $rentId);
    $stmt->bindParam(':state', $state);
    $stmt->execute();

    echo json_encode([$rentId , $state]);
?>