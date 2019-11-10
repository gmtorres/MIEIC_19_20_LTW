<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../etc/get_place_info.php');

    draw_header();
    ?>

    <div>
        <img src="" alt="">
    </div>

    <?php
        $placeId = $_GET['id'];
        drawPlace($placeId);
    ?>


</body>

</html>