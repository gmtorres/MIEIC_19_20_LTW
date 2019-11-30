<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/getPlaceInfo.php');

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $price = $_POST['price'];
    $Id = $_POST['placeId'];

    if($startDate == $endDate){
        header('Location: ../pages/manage.php');
        exit;
    }


    $db = Database::instance()->db();

    $dates = getAvailabitities($Id);

    //print_r($dates);
    foreach($dates as $date){
        if(($startDate < $date['endDate'] && $endDate > $date['endDate']) ||
            ($startDate > $date['startDate'] && $endDate < $date['endDate']) ||
            ($startDate < $date['startDate'] && $endDate > $date['startDate']) ){
            
            header('Location: ../pages/manage.php');
            exit;
        }
    }

    $stmt = $db->prepare('INSERT INTO
                            Available_Dates (PlaceId,startDate,endDate,price) VALUES(?,?,?,?)');
    $stmt->execute(array($Id,$startDate,$endDate,$price));

    //header('Location: ../pages/manage.php');

    echo(json_encode([$startDate,$endDate,$price]));


?>