<?php

    include_once ('../includes/database.php');
    $db = Database::instance()->db();

    if(isset($_GET['function'])){    
        $function = $_GET['function'];


        $placeId = $_POST['placeId'];
        $description = $_POST['description'];

        $stmt = $db->prepare('Select * from Place where placeId = ? and placeOwner = ?');
        $stmt->execute(array($placeId,$_SESSION['userId']));
        if($stmt->fecth() == FALSE){
            return json_encode(['error' => 'do not match']);
        }

        if($function == 'addExtra'){
            $value = addExtra($placeId,$description);         
        }else if($function == 'addRestriction'){
            $value = addRestriction($placeId,$description);      
        }
        echo $value;
        exit;
    }

    function addExtra($placeId,$description){
        
        $stmt = $db->prepare('Insert into ExtraAmenities(placeId,amenitiesDescription) values(?,?)');
        $stmt->execute(array($placeId,$description));

        return json_encode(['description' => $description]);
    }

    function addRestriction($placeId,$description){

        $stmt = $db->prepare('Insert into ExtraRestrictions(placeId,restrictionDescription) values(?,?)');
        $stmt->execute(array($placeId,$description));

        return json_encode(['description' => $description]);
    }


?>