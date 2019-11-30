<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/comments.php');
    include_once ('../templates/booking.php');
    include_once ('../actions/getPlaceInfo.php');

    $placeId = -1;
    if(isset($_GET['id']))
        $placeId = $_GET['id'];
    draw_headerArgs(["../css/calendar.css", "../css/header.css", "../css/house.css"] , []);

    $place = getPlace($placeId);
    if($place == null){
        unknownPage();
        exit;
    }

    drawPlaceTitle($place);
    ?>

    <div> 
        <img src="" alt="">
    </div>

    <?php

        drawPlaceDescription($place);
        drawUser($place);
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


        drawComments($placeId);

        if(isset($_SESSION['userID'])){
            drawCommentsSubmition($placeId,$_SESSION['userID']);
        }
    ?>

    </body>

</html>