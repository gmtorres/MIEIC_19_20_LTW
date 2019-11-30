<?php

    include_once ('../includes/database.php');

    if(isset($_GET['function'])){    
        $function = $_GET['function'];

        if($function == 'addExtra'){
            $value = addExtra($_POST['placeId'],$_POST['description']);         
        }else if($function == 'addRestriction'){
            $value = addRestriction($_POST['placeId'],$_POST['description']);      
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


?>