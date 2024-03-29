<?php


    include_once ('../includes/database.php');
    include_once ('../includes/session.php');
    include_once ('../actions/generalChecks.php');


    if(isset($_POST['function'])){    
        $function = $_POST['function'];

        

        if($function == 'addExtra'){
            $value = addExtra($_POST['placeId'] , validate_input($_POST['description']));         
        }else if($function == 'removeExtra'){
            $value = removeExtra($_POST['id']);         
        }else if($function == 'addRestriction'){
            $value = addRestriction($_POST['placeId'] , validate_input($_POST['description']));         
        }else if($function == 'removeRestriction'){
            $value = removeRestriction($_POST['id']);         
        }
        
        echo json_encode($value);
        exit;
    }

    function addExtra($placeId,$description){

        if(!isPlaceFromUser($_SESSION['userId'],$placeId)){
            echo json_encode(['error' => 'do not match']);
            exit;
        }

        $db = Database::instance()->db();

        $stmt = $db->prepare('Insert INTO ExtraAmenities(placeID,amenitiesDescription) values (?,?)');
        $stmt->execute(array($placeId,$description));

        $id = $db->lastInsertId();

        return ['id' => $id, "description" => $description];

    }
    
    function removeExtra($extraId){

        if(!isExtraFromUser($_SESSION['userId'],$extraId)){
            echo json_encode(['error' => 'do not match']);
            exit;
        }

        $db = Database::instance()->db();

        $stmt = $db->prepare('Delete From ExtraAmenities where amenitiesID=?');
        $stmt->execute(array($extraId));
        return ['id' => $extraId];
    }
    function addRestriction($placeId,$description){

        if(!isPlaceFromUser($_SESSION['userId'],$placeId)){
            echo json_encode(['error' => 'do not match']);
            exit;
        }

        $db = Database::instance()->db();

        $stmt = $db->prepare('Insert INTO ExtraRestrictions(placeID,restrictionDescription) values (?,?)');
        $stmt->execute(array($placeId,$description));

        $id = $db->lastInsertId();

        return ['id' => $id, "description" => $description];

    }
    
    function removeRestriction($extraId){

        if(!isRestrictionFromUser($_SESSION['userId'],$extraId)){
            echo json_encode(['error' => 'do not match']);
            exit;
        }

        $db = Database::instance()->db();

        $stmt = $db->prepare('Delete From ExtraRestrictions where restrictionID=?');
        $stmt->execute(array($extraId));
        return ['id' => $extraId];
    }

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>