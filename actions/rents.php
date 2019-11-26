<?php

    include_once ('../includes/database.php');
    include_once ('../actions/user_info.php');
    include_once ('../actions/get_place_info.php');

    function getRentsByUser($userId){

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from Rent
                              where Rent.tourist = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $rents = $stmt->fetchAll();
        return $rents;
    }

    function getRentsByOwner($userId){

        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from Rent
                            Inner Join Place on Rent.place = Place.placeID
                              where Place.placeOwner = :userId
                                ');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $rents = $stmt->fetchAll();
        return $rents;
    }

    function displayReservations($rents){
        ?>
            <div id='reservations'>
        <?php
        foreach($rents as $rent){
            //print_r($rent);
            $place = getPlace($rent['place']);
            ?>
                <div class ='request' id="request<?=$rent['rentID']?>">
                    
                    <a href="./house.php?id=<?= $place['placeID'] ?> ">
                    <h3> <?= $place['title'] ?> </h3>
                    </a>
                    <h3> <?= $rent['startDate'] ?> </h3>
                    <h3> <?= $rent['endDate'] ?> </h3>

                    <?php 
                        if($rent['accepted'] == 0){
                            ?> <h3> Waiting for response </h3> <?php
                        }else if($rent['accepted'] == 1){
                            ?> <h3> Accepted </h3> <?php
                        }else if($rent['accepted'] == -1){
                        ?> <h3> Declined </h3> <?php
                        }
                         
                    ?>

                </div>

            <?php
        }
        ?>
            </div>
        <?php
    }

    function displayRequests($rents){

        foreach($rents as $rent){
            $tourist = getUserInfo($rent['tourist']);
            ?>
                <div class ='request' id="request<?=$rent['rentID']?>">

                    <a href="./house.php?id=<?= $rent['place'] ?> ">
                        <h3> <?= $rent['title'] ?> </h3>
                    </a>
                    <a href="./user.php?id=<?= $rent['tourist'] ?> ">
                        <h3> <?= $tourist['userName'] ?> </h3>
                    </a>

                    <h3> <?= $rent['startDate'] ?> </h3>
                    <h3> <?= $rent['endDate'] ?> </h3>

                    <?php 
                        if($rent['accepted'] == 0){
                            ?> 
                                <h3> Waiting for response </h3>
                                <div id='response'>
                                    <button onclick="acceptOffer(<?= $rent['rentID']?>)">Accept</button> 
                                    <button onclick="declineOffer(<?= $rent['rentID']?>)">Decline</button>
                                </div>
                            <?php
                        }else if($rent['accepted'] == 1){
                            ?> <h3> Accepted </h3> <?php
                        }else if($rent['accepted'] == -1){
                            ?> <h3> Declined </h3> <?php
                        }else if($rent['accepted'] == -2){
                            ?> <h3> Exceded time </h3> <?php
                        }
                         
                    ?>

                </div>

            <?php
        }
    }



?>