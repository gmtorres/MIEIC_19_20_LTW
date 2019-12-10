<?php

    include_once ('../includes/database.php');
    include_once ('../actions/getPlaceInfo.php');

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
                                Place.city,Place.maxGuests as maxGuests, 
                                IFNULL(avg(comment.classification),\'No Reviews yet\') as class,
                                place.placeDescription ,place.placeAddress
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
        <div id='userInfo'>
            <div id='userPicture'>
                <a href="user.php?id=<?=$user['userID']?>"> 
                    <img src="../images/profile/<?=$profilePic?>.jpg"> 
                </a>
            </div>
                <div id='userDetails'>
                <h2 id='userName'> <?= $user['userName'] ?> </h2>
                <h4 id='userEmail'> <?= $user['email'] ?> </h4>
                <h4 id='userPhoneNumber'> <?= $user['phoneNumber'] ?> </h4>
            </div>
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
                <div class='userPlace'><?php
                    $images = getPlaceImages($place['id']);
                    displayPlaceImage($images);?>
                    <div class='userPlaceInfo'>
                        <h2> <?= $place['title']?> </h2>
                        <h3>
                        <?php
                            if($place['class'] != 'No Reviews yet'){
                        ?>
                            Classification 
                        <?php
                            }   
                        ?>
                        <?= $place['class']?> </h3>
                        <h3> <?= $place['city']?> </h3>
                        <p> <?= $place['placeDescription']?> </p>
                    </div>
                    </div>
                </a>
            <?php
    }

    function drawMainUserMenu(){
        $number = count(getRentsByOwnerForApproval($_SESSION['userId']));
        if($number > 9) $number = "+9";
    ?>  
    <div id="userMenu">
        <ul>
            <li> <a href="editProfile.php" > Edit Profile </a> </li>
            <li> <a href="manage.php" > Manage Places </a> </li>
            <li> <a href="requests.php" > Requests
                <?php if($number != 0){ ?>
                    <span id='numberRequest'> <?=$number?> </span> 
                <?php }?>
                </a> </li>
            <li> <a href="myReservations.php" > My reservations </a> </li>

        </ul>
    </div>

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
        return $user['profilePicture'];
    }

?>