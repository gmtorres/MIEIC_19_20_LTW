<?php

    include_once ('../includes/session.php');

    $db = new PDO('sqlite:../database.db');

    $title = $_POST['Title'];
    $zone = $_POST['Zone'];
    $address = $_POST['Address'];
    $description = $_POST['Description'];
    $maxGuests = $_POST['maxGuests'];
    $placeOwner = $_SESSION['userId'];

    $placeId = $_POST['placeId'];

    $stmt = $db->prepare('Update Place set title = ? , city = ? , placeAddress = ?, placeDescription = ?, maxGuests = ? where placeId = ?');
    $stmt->execute(array($title,$zone,$address,$description,$maxGuests,$placeId));
    
    header("Location: ../pages/houseManage.php?id=".$placeId);

?>