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

    function sortFunction( $a, $b ) {
        return strtotime($a["startDate"]) - strtotime($b["startDate"]);
    }

    function getAvailabitities($placeId){

        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from Available_Dates where PlaceId = :placeid');
        $stmt->bindParam(':placeid',$placeId);
        $stmt->execute();

        $dates = $stmt->fetchAll();
        usort($dates, "sortFunction");
        return $dates;

    }

    function drawAvailables($dates){
        foreach($dates as $date){
            ?>

                <h3> <?= $date['startDate']?> </h3>
                <h3> <?= $date['endDate']?> </h3>
                <h3> <?= $date['price']?> </h3>
            
            <?php
        }
    }

    function getAvailabititiesArray($availabities){
        $datas = array();
        foreach($availabities as $available){
            $temp = array($available['startDate'] , $available['endDate']);
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

?>