<?php

    function search(){
        $db = new PDO('sqlite:../database.db');
        $query = null;

        $query1 = 'Select Place.placeId as id,Place.title, Place.city,Place.maxGuests as maxGuests, 
                IFNULL(avg(comment.classification),\'No Reviews yet\') as class,place.placeDescription
                from place 
                LEFT JOIN Comment 
                    on Place.placeid = comment.placeid
                Left Join Available_Dates
                    on place.placeId  = Available_Dates.placeId 
                where 
                    Place.city = :city and maxGuests >= :guests group by place.placeId';

        $query2 = 'Select placeId as PlaceId2, 
                    sum(max(0,julianday(min(endDate, :endDate)) - julianday(max(startDate,:startDate)))*price) as rentPrice, 
                    sum(max(0,julianday(min(endDate, :endDate)) - julianday(max(startDate,:startDate)))) as totalDays
                    from Available_Dates where endDate > :startDate 
                    and startDate < :endDate 
                    group by placeId';

        $query3='Select Place.placeId as id,Place.title, Place.city,Place.maxGuests as maxGuests, 
                IFNULL(avg(comment.classification),\'No Reviews yet\') as class,place.placeDescription
                from place 
                LEFT JOIN Comment 
                    on Place.placeid = comment.placeid
                Left Join Available_Dates
                    on place.placeId  = Available_Dates.placeId 
                where 
                    Place.city = :city and maxGuests >= :guests 
                    and julianday(Available_Dates.startDate) <= julianday(:startDate) 
                    and julianday(Available_Dates.endDate) > julianday(:endDate)
                    group by place.placeId';

        $query = $query1;

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
            $endDate = date('Y-m-d', strtotime($startDate . ' + 1 days'));
            $query = 'Select * from ( ' . $query . ' ) INNER JOIN ( ' . $query2 . 
                ' ) on PlaceId2 = id where rentPrice <= :maxRent and totalDays = (julianday(:endDate) - julianday(:startDate))  '; 
            if(!empty($_GET['endDate']) && isset($_GET['endDate'])){
                $endDate = $_GET['endDate'];
                if(!empty($_GET['PriceRange']) && isset($_GET['PriceRange'])){
                    $maxPrice = $_GET['PriceRange'];
                }else{
                    $maxPrice = 10000;
                }
            }else{
                $query=$query3;
            }
        }



        //echo($query);
        
        //$query = $query . 'limit 20';
        $city = $_GET['Destiny'];

        $stmt = $db->prepare($query);
        $stmt->bindParam(':city', $city,PDO::PARAM_STR);
        $stmt->bindParam(':guests', $guests);
        if(!empty($_GET['startDate']) && isset($_GET['startDate'])){
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
            if(!empty($_GET['endDate']) && isset($_GET['endDate'])){
                if(!empty($_GET['PriceRange']) && isset($_GET['PriceRange'])){
                    $stmt->bindParam(':maxRent', $maxPrice,PDO::PARAM_INT);
                }
            }
        }
        


        $stmt->execute();
        $places = $stmt->fetchAll();


        //print_r($places);

        return $places;

        

    }

    function displaySearch($places){
        ?>
            <section id='searchSection'>
        <?php
        if(count($places) == 0){
            ?>
            <h3> No homes match your parameteres. </h3>
            <?php
        }
        foreach($places as $place){
            ?>  
                <a href="./house.php?id=<?= $place['id']?>" >
                    <div class='searchplace'><?php
                        $images = getPlaceImages($place['id']);
                        displayPlaceImage($images);?>
                        <div class='userPlaceInfo'>
                            <h2> <?= $place['title']?> </h2>
                            <h3>
                            <?php
                                if($place['class'] != 'No Reviews yet'){
                            ?>
                                Classification 
                            <?php
                                }   
                            ?>
                            <?= $place['class']?> </h3>
                            <h3> <?= $place['city']?> </h3>
                            <p> <?= $place['placeDescription']?> </p>
                            <?php if(isset($place['rentPrice'])){ ?><h4> <?= $place['rentPrice']?> € </h4> <?php } ?>
                        </div>
                    </div>
                </a>
            <?php
        } 
        ?>
            </section>
        <?php
    }

?>