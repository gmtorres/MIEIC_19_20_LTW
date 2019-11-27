<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/rents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs([],[["../js/requests.js","defer"]]);

    $requests = getRentsByOwner($_SESSION['userID']);

    displayRequests($requests);

    draw_footer();

?>