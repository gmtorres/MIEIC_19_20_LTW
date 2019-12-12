<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');
    include_once ('../actions/getRents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/user.css"], []);
    draw_manager();
    draw_footer();

?>