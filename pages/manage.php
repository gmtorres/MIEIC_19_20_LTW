<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_header();

    draw_manager();

    draw_footer();


?>