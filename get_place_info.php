
<?php 

function drawPlace($place_id)
{
    $db = new PDO('sqlite:database.db');

    $stmt = $db->prepare('Select * from Place 
                            JOIN User 
                            where user.userid = place.placeOwner 
                            and placeid = :place_id');
    $stmt->bindParam(':place_id', $place_id);
    $stmt->execute();
    $place = $stmt->fetch();

    ?>

    <h1> <?= $place['title'] ?> </h1>
    <h3> <?= $place['userName'] ?> </h3>
    <h4> <?= $place['area'] ?> </h4>
    <h1> <?= $place['placeAddress'] ?> </h1>
    <h3> <?= $place['placeDescription'] ?> </h3>

<?php

} ?>
