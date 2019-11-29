<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/addPlace.css"], []);
    draw_addPlace();
    draw_footer();

?>