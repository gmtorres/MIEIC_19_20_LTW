<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../get_place_info.php');
    include_once ('../getUserInfo.php');
    
    draw_header();
    drawPlace(3);
    getUserInfo(2);
    draw_footer();

?>