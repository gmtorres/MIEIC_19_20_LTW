<?php

    include_once ('../includes/database.php');
    include_once ('../includes/session.php');
    include_once ('../actions/generalChecks.php');

    $description =  validate_input($_POST['description']);
    $placeId = $_SESSION['placeManaging'];

    if(!isPlaceFromUser($_SESSION['userId'],$placeId)){
        echo json_encode(['error' => 'do not match']);
        exit;
    }

    $db = Database::instance()->db();

    do {
        $originalFileName = '../images/place/'. substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 32)), 0, 32) . '.jpg';

        $stmt = $db->prepare('Select * from placeImage where imagePath = ?');
        $stmt->execute(array($originalFileName));
        
    } while ($stmt->fetch() != FALSE);
    

    if(move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName) == FALSE){
        exit; //error
    }else{
        $stmt = $db->prepare('Insert into placeImage(placeID,imageDescription,imagePath) values(?,?,?)');
        $stmt->execute(array($placeId,$description,$originalFileName));
    }
    
    header('Location: ../pages/houseManage.php?id='.$placeId);

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>