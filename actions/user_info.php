<?php

    function getUserInfo($userId){

        $db = new PDO('sqlite:../database.db');

        $stmt = $db->prepare('Select * from User 
                              where User.userId = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user !== false){
            return $user;
        }
        else
            echo "PAGE NOT FOUND";

    }

    function getUserPlaces($userId){

        $db = new PDO('sqlite:../database.db');

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
        ?>

            <h2> <?= $user['userName'] ?> </h2>
            <h4> <?= $user['email'] ?> </h4>
            <h4> <?= $user['phoneNumber'] ?> </h4>

        <?php
    }

    function drawUserPlaces($places){

        if(count($places) == 0){
            ?>
            <h3> This user has no places to rent. </h3>
            <?php
        }

        foreach($places as $place){
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

    }

    function drawMainUserMenu(){

    ?>
        <ul>
            <li> <a href="manage.php" > Manage Places </a> </li>
            <li> <a href="" > Settings </a> </li>

        </ul>

    <?php

    }

    function drawMainUser(){
        $userId = $_SESSION['userId'];

        drawUserInfo($userId);


    }



?>