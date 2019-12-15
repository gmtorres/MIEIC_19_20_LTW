<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    function isPlaceFromUser($user,$place){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM Place where placeOwner = ? and placeId = ?");
        $stmt->execute(array($user,$place));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

    function isAvailableFromUser($user,$available){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM Available_Dates Inner JOIN Place on Available_Dates.placeId = Place.placeId where placeOwner = ? and Available_DatesID = ?");
        $stmt->execute(array($user,$available));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

    function isExtraFromUser($user,$extra){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM ExtraAmenities Inner JOIN Place on ExtraAmenities.placeID = Place.placeId where placeOwner = ? and amenitiesID = ?");
        $stmt->execute(array($user,$extra));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

    function isRestrictionFromUser($user,$restriction){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM ExtraRestrictions Inner JOIN Place on ExtraRestrictions.placeID = Place.placeId where placeOwner = ? and restrictionID = ?");
        $stmt->execute(array($user,$restriction));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

    function isRentFromUser($user,$rent){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM Rent Inner JOIN Place on Rent.place = Place.placeId where placeOwner = ? and rentID = ?");
        $stmt->execute(array($user,$rent));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

    function isPicPlaceFromUser($user,$pic){
        $db = Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM PlaceImage Inner JOIN Place on PlaceImage.placeID = Place.placeId where placeOwner = ? and placeImageID = ?");
        $stmt->execute(array($user,$rent));
        $res = $stmt->fetch();
        return $res != FALSE;
    }

?>