<?php


include_once ('../includes/database.php');

function getPlace($place_id)
{
    $db = Database::instance()->db();

    $stmt = $db->prepare('Select * from Place 
                            JOIN User 
                            where user.userid = place.placeOwner 
                            and placeid = :place_id');
    $stmt->bindParam(':place_id', $place_id);
    $stmt->execute();
    $place = $stmt->fetch();

    if ($place !== false) {
        return $place;
    } else
        echo "Page not found";
}


function drawPlaceTitle($place)
{
    ?>

    <h2> <?= $place['title'] ?> </h2>

<?php
}

function drawPlaceDescription($place)
{
    ?>

    <h2> <?= $place['placeDescription'] ?> </h2>

<?php
}

function drawUser($place)
{
    ?>
    <a href="./user.php?id= <?= $place['placeOwner'] ?> ">
        <h3> <?= $place['userName'] ?> </h3>
    </a>
<?php
}

function drawPlaceAmenities($place)
{
    if ($place['swimmingPool'] == 1) {
    ?>

    <h3> SwimingPoll: yes </h3>

    <?php
    } else {
    ?>

    <h3> SwimingPoll: no </h3>

    <?php
    }

    if ($place['wiFi'] == 1) {

    ?>

    <h3> WiFi: yes </h3>
    
    <?php
    } else {
    ?>

    <h3> Wifi: no </h3>
    
    <?php
    }

    if ($place['houseMaid'] == 1) {

    ?>

    <h3> HouseMaid: yes </h3>
    
    <?php
    } else {
    ?>

    <h3> HouseMaid: no </h3>
    
    <?php
    }
    ?>
    <h3> <?= $place['placeAddress'] ?> </h1>
    <?php
    }
