<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $placeId = $_POST['PlaceId'];
    $tourist = $_POST['Tourist'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO 
                        Rent(place,tourist,price,startDate,endDate)
                        VALUES (?,?,?,?,?)');
    $stmt->execute(array($placeId,$tourist,100,$startDate,$endDate));

    header('Location: ../pages/homePage.php');


?>