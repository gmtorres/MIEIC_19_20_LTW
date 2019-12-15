<?php

    include_once ('../includes/database.php');
    include_once ('../includes/session.php');
    include_once ('../actions/generalChecks.php');

    if(isset($_GET['function'])){    
        $function = $_GET['function'];


        $placeId = validate_input($_POST['placeId']);

        if(!isPlaceFromUser($_SESSION['userId'],$placeId)){
            echo json_encode(['error' => 'do not match']);
            exit;
        }

        $description = validate_input($_POST['description']);

        //$stmt = $db->prepare('Select * from Place where placeId = ? and placeOwner = ?');
        //$stmt->execute(array($placeId,$_SESSION['userId']));
        //if($stmt->fetch() == FALSE){
            //return json_encode(['error' => 'do not match']);
        //}

        if($function == 'addExtra'){
            $value = addExtra($placeId,$description);         
        }else if($function == 'addRestriction'){
            $value = addRestriction($placeId,$description);      
        }
        echo $value;
        exit;
    }

    function addExtra($placeId,$description){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Insert into ExtraAmenities(placeId,amenitiesDescription) values(?,?)');
        $stmt->execute(array($placeId,$description));

        return json_encode(['description' => $description]);
    }

    function addRestriction($placeId,$description){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Insert into ExtraRestrictions(placeId,restrictionDescription) values(?,?)');
        $stmt->execute(array($placeId,$description));

        return json_encode(['description' => $description]);
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


?>