<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/comments.php');
    include_once ('../templates/booking.php');
    include_once ('../actions/getPlaceInfo.php');

    $placeId = -1;
    if(isset($_GET['id']))
        $placeId = $_GET['id'];
    draw_headerArgs(["../css/headerBlack.css", "../css/house.css","../css/slideshow.css","../css/calendar.css"] , 
                    [["../js/slideshow.js","defer"],["../js/addComment.js","defer"]]);

    $place = getPlace($placeId);
    if($place == null){
        unknownPage();
        exit;
    }

    drawPlaceTitle($place);
    drawPlaceCity($place);
    drawPlaceLocation($place);

    $images = getPlaceImages($placeId);
    displayPlaceImages($images);
    drawPlaceDescription($place);

    ?>
        <section id='generalInfoRentContainer'>
    <?php
    drawUser($place);


    drawPlaceAmenities($place);

    $extras = getExtraAmenities($placeId);
    $restrictions = getExtraRestrictions($placeId);

    displayExtraAmenities($extras);
    displayExtraRestrictions($restrictions);


    if(isset($_SESSION['userId'])){
        $availables = getAvailabitities($placeId);
        $rents = getRents($placeId);
        drawRentSubmition($placeId,$_SESSION['userId'] , $rents, $availables );
    }
    ?>
        </section>
    <?php   
    
    drawComments($placeId);

    if(isset($_SESSION['userId'])){
        drawCommentsSubmition($placeId,$_SESSION['userId']);
    }
    
    draw_footer();
?>
