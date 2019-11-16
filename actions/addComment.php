<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $placeId = $_POST['PlaceId'];
    $writer = $_POST['WriterId'];
    $title = $_POST['Title'];
    $comment = $_POST['Comment'];
    $classification = $_POST['Classification'];

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO 
                        Comment(placeID,writer,classification,title,comment) 
                        VALUES (?,?,?,?,?)');
    $stmt->execute(array($placeId,$writer,$classification,$title,$comment,));

    header('Location: ../pages/homePage.php');


?>