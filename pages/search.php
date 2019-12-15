<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/search.php');

    draw_headerArgs(["../css/headerBlack.css","../css/calendar.css","../css/search.css"],[["../js/slider.js","defer"]]);

    drawSearchForm();

    $places = search();

    displaySearch($places);

    draw_footer();

?>