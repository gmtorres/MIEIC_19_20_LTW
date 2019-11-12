<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../actions/get_place_info.php');

    $placeId = $_GET['id'];
    draw_header();
    $place = getPlace($placeId);
    drawPlaceTitle($place);
    ?>

    <div>
        <img src="" alt="">
    </div>

    <?php
        drawPlaceDescription($place);
        drawUser($place);
        drawPlaceAmenities($place);
    ?>

    </body>

</html>