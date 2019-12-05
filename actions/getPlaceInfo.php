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
                <div id='available<?= $date["Available_DatesID" ]?>' >
                    <h3> <?= $date['startDate']?> </h3>
                    <h3> <?= $date['endDate']?> </h3>
                    <h3> <?= $date['price']?> </h3>
                    <button type='button' onclick='removeAvailable(<?= $date["Available_DatesID" ] ?>,calendarioRef)'> Remove </button>
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
        <?php
            foreach($images as $image){
                ?>
                <div id='placeImage'>
                    <img src="<?=$image['imagePath']?>" alt="Image of Place" width="400" height="200">
                    <h4><?=$image['imageDescription']?></h4>
                </div>
                <?php
            }
        ?>
            </div>
        <?php
    }
?>