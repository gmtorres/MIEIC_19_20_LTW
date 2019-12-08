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
            return null;
    }


    function drawPlaceTitle($place)
    {
        ?>

        <h1> <?= $place['title'] ?> </h1>

    <?php
    }

    function drawPlaceDescription($place)
    {
        ?>

        <h2 id = 'description'>  <?= $place['placeDescription'] ?> </h2>

    <?php
    }

    function drawPlaceCity($place)
    {
        ?>

        <h3> <?= $place['city'] ?> </h3>

    <?php
    }

    function drawUser($place)
    {   
        $profilePic = getProfilePic($place['placeOwner']);
        ?>
        <div id='userPicture'>
            <a href="user.php?id=<?=$place['placeOwner']?>"> 
                <img src="../images/profile/<?=$profilePic?>.jpg"> 
            </a>
        </div>
        <a href="./user.php?id= <?= $place['placeOwner'] ?> ">
            <h3> <?= $place['userName'] ?> </h3>
        </a>
    <?php
    }

function drawPlaceAmenities($place)
{
    if ($place['swimmingPool'] == 1) {
    ?>
        <h3 id = 'available' > SwimingPoll </h3>
    <?php
    } else {
    ?>
        <h3 id = 'unavailable'> SwimingPoll </h3>
    <?php
    }

    if ($place['wiFi'] == 1) {
    ?>
        <h3 id = 'available'> WiFi </h3>
    <?php
    } else {
    ?>
        <h3 id = 'unavailable'> Wifi </h3>
    <?php
    }

    if ($place['houseMaid'] == 1) {
    ?>
        <h3 id = 'available'> HouseMaid </h3>
    <?php
    } else {
    ?>
        <h3 id = 'unavailable'> HouseMaid </h3>
    <?php
    }
    ?>
    <h3 id = 'available'> <?= $place['placeAddress'] ?> </h1>
    <?php
}

    function sortFunction( $a, $b ) {
        return strtotime($a["startDate"]) - strtotime($b["startDate"]);
    }

    function getAvailabitities($placeId){

        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from Available_Dates where PlaceId = :placeid and endDate >= date(\'now\')');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $dates = $stmt->fetchAll();
        usort($dates, "sortFunction");
        return $dates;

    }

    function drawAvailables($dates){
        ?>
            <div id='availables'>
        <?php
        foreach($dates as $date){
            ?>
                <div id='available <?= $date["Available_DatesID" ]?>' >
                    <h3> <?= $date['startDate']?> </h3>
                    <h3> <?= $date['endDate']?> </h3>
                    <h3> <?= $date['price']?> </h3>
                    <button type='button' onclick='removeAvailable(<?= $date["Available_DatesID"]?> , calendarioRef)'> Remove </button>
                </div>
            <?php
        }
        ?>
            </div>
        <?php
    }

    function getAvailabititiesArray($availabities){
        $datas = array();
        foreach($availabities as $available){
            $temp = array($available['startDate'] , $available['endDate'] , $available['price']);
            array_push($datas,$temp);
        }
        return $datas;
    }

    function getRents($placeId){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from Rent where place = :placeid and (accepted = 1 or accepted = 0)');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $rents = $stmt->fetchAll();
        return $rents;
    }

    function getRentsArray($rents){
        $datas = array();
        foreach($rents as $rent){
            $temp = array($rent['startDate'] , $rent['endDate']);
            array_push($datas,$temp);
        }
        return $datas;
    }


    function getExtraAmenities($placeId){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from ExtraAmenities where placeId = :placeid');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $extras = $stmt->fetchAll();
        return $extras;
    }

    function getExtraRestrictions($placeId){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from ExtraRestrictions where placeId = :placeid');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $extras = $stmt->fetchAll();
        return $extras;
    }
    
    function displayExtraAmenities($extras){
        ?>
            <div id='Amenities'>
                <h3>Extra Amenities</h3> 
        <?php
        if(count($extras) == 0){
            ?>
                <h4>No extra amenities</h4> 
            <?php
        }
        foreach($extras as $extra){
            ?>
                <div id='extraAmenity'>
                    <h3> <?= $extra['amenitiesDescription'] ?> </h3>
                </div>
            <?php
        }
        ?>
            </div>
        <?php
    }
    function displayExtraRestrictions($extras){
        ?>
            <div id='Restrictions'>
                <h3>Extra Restrictions</h3> 
        <?php
        if(count($extras) == 0){
            ?>
                <h4>No extra restrictions</h4> 
            <?php
        }
        foreach($extras as $extra){
            ?>
                <div id='extraRestriction'>
                    <h3> <?= $extra['restrictionDescription'] ?> </h3>
                </div>
            <?php
        }
        ?>
            </div>
        <?php
    }

    function getPlaceImages($placeId){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from PlaceImage where placeId = :placeid');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $images = $stmt->fetchAll();
        return $images;
    }

    function displayPlaceImages($images){
        ?> 
            <div id='placeImages'>
                <div id='image_slideshow'>
        <?php
            foreach($images as $image){
                ?>
                <div class='slideImage fade'>
                    <img src="<?=$image['imagePath']?>" alt="Image of Place" > 
                    <h4><?=$image['imageDescription']?></h4>
                </div>
                <?php
            }
        ?>  
                </div>
            </div>
        <?php
    }
    
    function displayPlaceImagesRemove($images){
        ?> 
            <div id='placeImages'>
                <div id='image_slideshow'>
        <?php
            foreach($images as $image){
                ?>
                <div id="image<?=$image['placeImageID']?>" class='slideImage fade'>
                    <img src="<?=$image['imagePath']?>" alt="Image of Place" > 
                    <h4><?=$image['imageDescription']?></h4>
                    <button class="removeImage" type='button' onclick="removeImage(<?=$image['placeImageID']?>)"> Delete Picture </button>
                </div>
                <?php
            }
        ?>  
                </div>
            </div>
        <?php
    }

    function displayPlaceImage($images){
        ?> 
            <div id='placeImage'>
                <?php
                    if (empty($images)) {?>
                        <img src="http://www.liven.pt/wp-content/uploads/2015/05/Lisboa-Portugal.jpg" alt="Stock Image of Place">
                    <?php 
                    }
                    if (!empty($images)) {
                    $image = $images[0];
                    ?>
                    <img src="<?=$image['imagePath']?>" alt="Image of Place">
                <?php
                }
                ?>
        </div>
        <?php
    }
?>