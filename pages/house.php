<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/comments.php');
    include_once ('../actions/get_place_info.php');

    $placeId = -1;
    if(isset($_GET['id']))
        $placeId = $_GET['id'];
    draw_header();

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
        drawComments($placeId);
        if(isset($_SESSION['userID'])){
            drawCommentsSubmition($placeId,$_SESSION['userID']);
        }
    ?>

    </body>

</html>