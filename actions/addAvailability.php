<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $price = $_POST['price'];
    $Id = $_POST['placeId'];

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO
                            Available_Dates (PlaceId,startDate,endDate,price) VALUES(?,?,?,?)');
    $stmt->execute(array($Id,$startDate,$endDate,$price));

    header('Location: ../pages/manage.php');


?>