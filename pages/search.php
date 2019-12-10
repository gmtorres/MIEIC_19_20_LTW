<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/search.php');

    draw_headerArgs(["../css/header.css","../css/calendar.css","../css/search.css"],[]);

    drawSearchForm();

    $places = search();

    displaySearch($places);

    draw_footer();

?>