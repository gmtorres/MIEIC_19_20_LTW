<?php 

function drawHotPicks()
{
    $db = new PDO('sqlite:../database.db');

    $stmt = $db->prepare('Select Place.placeId as id, Place.title, place.placeDescription ,  avg(comment.classification) as class
                            from place 
                            JOIN Comment 
                            where Place.placeID = comment.placeId 
                            group by place.placeid 
                            order by class DESC
                            limit 5');
    $stmt->execute();
    $places = $stmt->fetchAll();
    
    foreach($places as $place){
        ?>  
            <a href="./house.php?id=<?= $place['id']?>" >
                <div id='HotPick'>
                    <h3> <?= $place['title']?> </h3>
                    <h3> <?= $place['class']?> </h3>
                    <h3> <?= $place['placeDescription']?> </h3>
                </div>
            </a>
        <?php
    } 
        

} ?>