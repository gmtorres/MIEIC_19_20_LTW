<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/auth.php');

    if(isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');
    
    draw_header();
    draw_register();
    draw_footer();

?>