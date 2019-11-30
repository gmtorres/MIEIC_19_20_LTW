<?php

    include_once ('../includes/database.php');


    function getUserInfo($userId){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from User 
                              where User.userId = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user !== false){
            return $user;
        }
        else{
            echo "PAGE NOT FOUND";
        }
    }

    function getUserID($userName){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select userID from User 
                              where userName = :userName
                                ');
        $stmt->bindParam(':userName', $userName);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user !== false){
            return $user['userID'];
        }
        else
            return 0;
    }

    function getUserPlaces($userId){
        $db = Database::instance()->db();
        $stmt1 = $db->prepare('Select * from User 
                              where User.userId = :userId
                                ');
        $stmt1->bindParam(':userId', $userId);
        $stmt1->execute();
        $user1 = $stmt1->fetch();
        if($user1 == false)
            exit;
        $stmt = $db->prepare('Select Place.placeId as id,Place.title, 
                                Place.area,Place.maxGuests as maxGuests, 
                                IFNULL(avg(comment.classification),\'No Reviews yet\') as class,
                                place.placeDEscription
                                from 
                                    User Join Place on User.userId = Place.placeOwner 
                                    LEFT Join Comment on Place.placeid = comment.placeid 
                                where User.userId = :userId 
                                group by place.placeid;');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $places = $stmt->fetchAll();
        return $places;
    }
    function drawUserInfo($user){

        $profilePic = getProfilePic($user['userID']);
        ?>
        <div id='UserInfo'>
            <div id='userPicture'>
                <a href="user.php?id=<?=$user['userID']?>"> 
                    <img src="../images/profile/<?=$profilePic?>.jpg"> 
                </a>
            </div>
            <h2 id='userName'> <?= $user['userName'] ?> </h2>
            <h4 id='userEmail'> <?= $user['email'] ?> </h4>
            <h4 id='userPhoneNumber'> <?= $user['phoneNumber'] ?> </h4>
        </div>
        <?php
    }
    function drawUserPlaces($places){
        if(count($places) == 0){
            ?>
            <h3> This user has no places to rent. </h3>
            <?php
        }
        foreach($places as $place){
            drawPlace($place);
        } 
    }

    function drawPlace($place){
        ?>  
                <a href="./house.php?id=<?= $place['id']?>" >
                    <div id='UserPlace '>
                        <h3> <?= $place['title']?> </h3>
                        <h4> <?= $place['class']?> </h4>
                        <h4> <?= $place['area']?> </h4>
                        <h5> <?= $place['placeDescription']?> </h5>
                    </div>
                </a>
            <?php
    }

    function drawMainUserMenu(){
    ?>
        <ul>
            <li> <a href="editProfile.php" > Edit Profile </a> </li>
            <li> <a href="manage.php" > Manage Places </a> </li>
            <li> <a href="requests.php" > Requests </a> </li>
            <li> <a href="myReservations.php" > My reservations </a> </li>

        </ul>

    <?php
    }
    function drawMainUser(){
        $userId = $_SESSION['userId'];
        drawUserInfo($userId);
    }

    function getProfilePic($userId){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select profilePicture from User 
                              where User.userId = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user['profilePicture'] == null)
            return 'default';
        else 
            return $user['profilePicture'];
    }

?>