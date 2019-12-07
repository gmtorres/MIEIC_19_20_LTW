<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/comments.php');
    include_once ('../templates/booking.php');
    include_once ('../actions/getPlaceInfo.php');

    $placeId = -1;
    if(isset($_GET['id']))
        $placeId = $_GET['id'];
    draw_headerArgs(["../css/calendar.css", "../css/header.css", "../css/house.css","../css/slideshow.css"] , [["../js/slideshow.js","defer"]]);

    $place = getPlace($placeId);
    if($place == null){
        unknownPage();
        exit;
    }

    drawPlaceTitle($place);
    drawPlaceCity($place);

        $images = getPlaceImages($placeId);
        displayPlaceImages($images);
        drawPlaceDescription($place);
        drawPlaceAmenities($place);

        $availables = getAvailabitities($placeId);
        $rents = getRents($placeId);

        if(isset($_SESSION['userID'])){
            drawRentSubmition($placeId,$_SESSION['userID'] , $rents, $availables );
        }

        $extras = getExtraAmenities($placeId);
        $restrictions = getExtraRestrictions($placeId);

        displayExtraAmenities($extras);
        displayExtraRestrictions($restrictions);
        drawUser($place);
        drawComments($placeId);

        if(isset($_SESSION['userID'])){
            drawCommentsSubmition($placeId,$_SESSION['userID']);
        }
    ?>

    </body>

</html>