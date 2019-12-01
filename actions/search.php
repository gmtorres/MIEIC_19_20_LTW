<?php

    function search(){
        $db = new PDO('sqlite:../database.db');

        $query = 'Select Place.placeId as id,
                    Place.title, Place.city,
                    Place.maxGuests as maxGuests, 
                    IFNULL(avg(comment.classification),\'No Reviews yet\') as class,
                    place.placeDescription
                        from place LEFT JOIN Comment 
                            on Place.placeid = comment.placeid 
                        where Place.city = :city group by place.placeId
                    ';

        $city = $_GET['Destiny'];
        $guests = $_GET['guests'];
        

        if(!empty($_GET['guests'])){
            $query = 'Select * from (' . $query . ') where maxGuests >= :guests ';
        }
        
        $query = $query . 'limit 20';

        $stmt = $db->prepare($query);
        $stmt->bindParam(':city', $city);
        if(!empty($_GET['guests'])){
            $stmt->bindParam(':guests', $guests);
        }
        $stmt->execute();
        $places = $stmt->fetchAll();

        if(count($places) == 0){
            ?>
            <h3> No homes match your parameteres. </h3>
            <?php
        }


        foreach($places as $place){
            ?>  
                <div id='Search '>
                    <a href="./house.php?id=<?= $place['id']?>" >
                            <h3> <?= $place['title']?> </h3>
                            <h4> <?= $place['class']?> </h4>
                            <h4> <?= $place['city']?> </h4>
                            <h5> <?= $place['placeDescription']?> </h5>
                    </a>
                </div>
            <?php
        } 

    }

?>