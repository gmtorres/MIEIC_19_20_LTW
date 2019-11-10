<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/search.php');

    draw_header();

    search();

    draw_footer();

?>