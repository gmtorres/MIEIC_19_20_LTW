<?php 
    
    function drawPlace ($place_id){
        $db = new PDO('sqlite:../database.db');

        $stmt = $db->prepare('Select * from Place 
                            JOIN User 
                            where user.userid = place.placeOwner 
                            and placeid = :place_id');
        $stmt->bindParam(':place_id',$place_id);
        $stmt->execute();
        $places = $stmt->fetchAll();
        
        foreach( $places as $place) {   ?>

            <h1> <?=$place['title']?> </h1>
            <h3> <?=$place['userName']?> </h3>
            <h4> <?=$place['area']?> </h4>
            <h5> <?=$place['placeAddress']?> </h5>

            <h3> <?=$place['placeDescription']?> </h3>
        
        <?php   }
        
        }   
?>
    