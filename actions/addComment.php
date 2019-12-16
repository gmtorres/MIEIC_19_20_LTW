<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    checkCSRF();

    $placeId = validate_input($_SESSION['placeToComment']);
    $writerId = validate_input($_SESSION['userId']);
    $title = validate_input($_POST['title']);
    $comment = validate_input($_POST['comment']);
    $classification = validate_input($_POST['classification']);

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

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>