<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    checkCSRF();

    $placeId = $_SESSION['placeToRent'];
    $tourist = $_SESSION['userId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $price = $_POST['price'];

    if($tourist != $_SESSION['userId']){
        header("Location: ../pages/homePage.php");
        exit;
    }

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO 
                        Rent(place,tourist,price,startDate,endDate)
                        VALUES (?,?,?,?,?)');
    $stmt->execute(array($placeId,$tourist,$price,$startDate,$endDate));

    header('Location: ../pages/myReservations.php');


?>