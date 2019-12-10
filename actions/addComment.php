<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    $placeId = $_POST['placeId'];
    $writerId = $_POST['writerId'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];
    $classification = $_POST['classification'];

    if($writerId != $_SESSION['userId']){
        echo json_encode(["message" => "error"]);

        exit;
    }

    $db = Database::instance()->db();

    $stmt = $db->prepare('INSERT INTO 
                        Comment(placeID,writer,classification,title,comment) 
                        VALUES (?,?,?,?,?)');
    $stmt->execute(array($placeId,$writerId,$classification,$title,$comment));

    $stmt = $db->prepare('Select profilePicture,userName from User where userId = ?');
    $stmt->execute(array($writerId));
    $pic = $stmt->fetch();

    //header("Location: ../pages/house.php?id=$placeId");
    echo json_encode(["writerId" => $writerId , "title" => $title , "comment" => $comment , "classification" => $classification,"pic" => $pic['profilePicture'],"username" => $pic['userName']]);

?>