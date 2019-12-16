<?php 

    include_once ('../actions/getPlaceInfo.php');
    include_once ('../includes/database.php');


    function drawHotPicks() {
    
        $db = Database::instance()->db();

    $stmt = $db->prepare('Select Place.placeId as id, 
                                Place.title, Place.city,
                                place.placeDescription,
                                avg(comment.classification) as class
                            from place 
                            JOIN Comment 
                            where Place.placeID = comment.placeId 
                            group by place.placeid 
                            order by class DESC
                            limit 4');
    $stmt->execute();
    $places = $stmt->fetchAll();
    
    foreach($places as $place){
        ?>
            <a href="./house.php?id=<?= $place['id']?>" >
                <div class='HotPick'>
                    <?php
                        $placeId = $place['id'];
                        $images = getPlaceImages($placeId);
                        displayPlaceImage($images);
                    ?>
                    <h3> <?= $place['title']?> </h3>
                    <div class='otherInfo'>
                        <h4 class='classi'> <?= round($place['class']*100)/100?> </h4>
                        <h4 class='star star<?= round($place['class']) ?>'> ★ <h4>
                        <h4> <?= $place['city']?> </h4>
                    </div>
                </div>
            </a>
        <?php
    }
} ?>