<?php


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
                            ?> <h3> Accepted </h3>
                            <?php if( strtotime($rent['startDate'] ) > strtotime('+ 10 days') ) { ?>
                                <div id='cancelation'> <button onclick="cancellOffer(<?= $rent['rentID']?>)">Cancell</button> </div>
                            <?php } ?>
                            <?php
                        }else if($rent['accepted'] == -1){
                        ?> <h3> Declined </h3> <?php
                        }else if($rent['accepted'] == -2){
                        ?> <h3> Exceeded Time </h3> <?php
                        }else if($rent['accepted'] == -3){
                        ?> <h3> Cancelled </h3> <?php
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

        ?>
            <div id='rents'>
        <?php

        foreach($rents as $rent){
            ?>
                <div class ='request' id="request<?=$rent['rentID']?>">

                    <a href="./house.php?id=<?= $rent['place'] ?> ">
                        <h3> <?= $rent['title'] ?> </h3>
                    </a>
                    <a href="./user.php?id=<?= $rent['tourist'] ?> ">
                        <h3> <?= $rent['userName'] ?> </h3>
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
                            ?> <h3> Exceeded time </h3> <?php
                        }
                         
                    ?>

                </div>

            <?php
        }
        ?>
        </div>
        <?php
    }

?>