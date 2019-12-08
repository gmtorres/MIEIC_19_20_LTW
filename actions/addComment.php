<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $placeId = $_POST['PlaceId'];
    $writerId = $_POST['WriterId'];
    $title = $_POST['Title'];
    $comment = $_POST['Comment'];
    $classification = $_POST['Classification'];

    if($writerId != $_SESSION['userId']){
        header("Location: ../pages/homePage.php");
        exit;
    }

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO 
                        Comment(placeID,writer,classification,title,comment) 
                        VALUES (?,?,?,?,?)');
    $stmt->execute(array($placeId,$writerId,$classification,$title,$comment,));

    header("Location: ../pages/house.php?id=$placeId");


?>