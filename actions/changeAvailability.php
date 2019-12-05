<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/getPlaceInfo.php');

    if(isset($_POST['function'])){    
        $function = $_POST['function'];

        if($function == 'addAvailableDates'){
            $value = addAvailableDates();         
        }else if($function == 'removeAvailableDates'){
            $value = removeAvailableDates();      
        }
        echo $value;
        exit;
    }

    function addAvailableDates(){

        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $price = $_POST['price'];
        $placeId = $_POST['placeId'];

        if($startDate == $endDate){
            header('Location: ../pages/manage.php');
            exit;
        }


        $db = Database::instance()->db();

        $dates = getAvailabitities($placeId);

        foreach($dates as $date){
            if(($startDate < $date['endDate'] && $endDate > $date['endDate']) ||
                ($startDate > $date['startDate'] && $endDate < $date['endDate']) ||
                ($startDate < $date['startDate'] && $endDate > $date['startDate']) ){
                
                header('Location: ../pages/manage.php');
                exit;
            }
        }
        $stmt = $db->prepare('INSERT INTO Available_Dates (PlaceId,startDate,endDate,price) VALUES(?,?,?,?)');
        $stmt->execute(array($placeId,$startDate,$endDate,$price));
        
        $id = $db->lastInsertId();
        

        return json_encode(['id'=>$id,'start'=>$startDate,'end'=>$endDate,'price'=>$price]);
    }

    function removeAvailableDates(){
        $id = $_POST['availableId'];

        $db = Database::instance()->db();

        $stmt = $db->prepare('Select *  from Available_Dates where Available_DatesID = ?');
        $stmt->execute(array($id));
        $date = $stmt->fetch();

        $stmt = $db->prepare('Delete from Available_Dates where Available_DatesID = ?');
        $stmt->execute(array($id));

        return json_encode(['id' => $id,'start' => $date['startDate'] , 'end' => $date['endDate']]);
    }


?>