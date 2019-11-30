<?php
    include_once ('../includes/database.php');
    include_once ('../actions/user_info.php');
    include_once ('../actions/getPlaceInfo.php');


    if(isset($_GET['function'])){    
        $function = $_GET['function'];
        
        if($function == 'getRentsByUser'){
            $rent = getRentsByUser($_GET['userId']);
        }else if($function == 'getAllRentsByOwner'){
            $rent = getAllRentsByOwner($_GET['userId']);
        }else if($function == 'getRentsByOwnerForApproval'){
            $rent = getRentsByOwnerForApproval($_GET['userId']);
        }else if($function == 'getRentsByOwnerIntTheNextTimes'){
            $rent = getRentsByOwnerIntTheNextTimes($_GET['userId'],$_GET['time']);
        }
        echo json_encode($rent);
        exit;
    }

    function getRentsByUser($userId){

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select User.userName, Rent.place,Place.title, Place.placeId, Rent.rentID,Rent.tourist,startDate,endDate,accepted
                                from Rent
                                Inner Join Place on Rent.place = Place.placeID Inner Join User on User.userId = Rent.tourist
                              where Rent.tourist = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $rents = $stmt->fetchAll();
        return $rents;
    }

    function getAllRentsByOwner($userId){

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select User.userName, Rent.place,Place.title, Place.placeId, Rent.rentID,Rent.tourist,startDate,endDate,accepted
                            from Rent
                            Inner Join Place on Rent.place = Place.placeID Inner Join User on User.userId = Rent.tourist
                              where Place.placeOwner = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $rents = $stmt->fetchAll();
        return $rents;
    }
    function getRentsByOwnerForApproval($userId){

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select User.userName, Rent.place,Place.title, Place.placeId, Rent.rentID,Rent.tourist,startDate,endDate,accepted
                                from Rent
                                Inner Join Place on Rent.place = Place.placeID Inner Join User on User.userId = Rent.tourist
                                where Place.placeOwner = :userId and Rent.accepted = 0
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $rents = $stmt->fetchAll();
        return $rents;
    }

    function getRentsByOwnerIntTheNextTimes($userId,$days){ //time in days

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select User.userName, Rent.place,Place.title, Place.placeId, Rent.rentID,Rent.tourist,startDate,endDate,accepted
                                from Rent
                                Inner Join Place on Rent.place = Place.placeID Inner Join User on User.userId = Rent.tourist
                              where Place.placeOwner = ? and Rent.accepted = 1 and Rent.startDate < ?
                                ');
        $date = date('Y-m-d');
        $date = date('Y-m-d',strtotime($date. ' + '. $days .' days'));
        $stmt->execute(array($userId,$date));
        $rents = $stmt->fetchAll();
        return $rents;
    }
?>  