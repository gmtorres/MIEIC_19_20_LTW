<?php

    function search(){
        $db = new PDO('sqlite:../database.db');

        $query = 'Select Place.placeId as id, Place.title, Place.city, Place.maxGuests as maxGuests, 
                    IFNULL(avg(comment.classification),\'No Reviews yet\') as class, place.placeDescription, startDate, endDate
                        from place LEFT JOIN Comment 
                            on Place.placeid = comment.placeid 
                        Left Join Available_Dates
                            on place.placeId  = Available_Dates.placeId 
                        where Place.city = :city 
                        and julianday(Available_Dates.startDate) <= julianday(:startDate) 
                        and julianday(Available_Dates.endDate) > julianday(:startDate)
                        and maxGuests >= :guests
                        group by place.placeId 
                    ';

        $query2 = 'Select placeId as PlaceId2, 
                    sum(max(0,julianday(min(endDate, :endDate)) - julianday(max(startDate,:startDate)))*price) as rentPrice, 
                    sum(max(0,julianday(min(endDate, :endDate)) - julianday(max(startDate,:startDate)))) as totalDays
                    from Available_Dates where endDate > :startDate 
                    and startDate < :endDate 
                    order by placeId';

        $city = $_GET['Destiny'];
        $guests = 1;
        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d");
        $maxPrice = 10000;

        if(!empty($_GET['guests']) && isset($_GET['guests'])){
            $guests = $_GET['guests'];
        }
        
        if(!empty($_GET['startDate']) && isset($_GET['startDate'])){
            $startDate = $_GET['startDate'];
            if(!empty($_GET['endDate']) && isset($_GET['endDate'])){
                $endDate = $_GET['endDate'];
                $query = 'Select * from (' . $query . ') INNER JOIN (' . $query2 . 
                ') where rentPrice <= :maxRent and totalDays = (julianday(:endDate) - julianday(:startDate))  ';

                if(!empty($_GET['PriceRange']) && isset($_GET['PriceRange'])){
                    $maxPrice = $_GET['PriceRange'];
                }

            }
        }



        //echo($query);
        
        //$query = $query . 'limit 20';


        $stmt = $db->prepare($query);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':guests', $guests);
        $stmt->bindParam(':startDate', $startDate);
        if(!empty($_GET['endDate']) && isset($_GET['endDate'])){
            $stmt->bindParam(':endDate', $endDate);
        }
        if(!empty($_GET['PriceRange']) && isset($_GET['PriceRange'])){
            $stmt->bindParam(':maxRent', $maxPrice,PDO::PARAM_INT);
        }
        


        $stmt->execute();
        $places = $stmt->fetchAll();


        //print_r($places);



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
                            <h4> <?= $place['rentPrice']?> € </h4>
                            <h4> <?= $place['city']?> </h4>
                            <h5> <?= $place['placeDescription']?> </h5>
                    </a>
                </div>
            <?php
        } 

    }

?>