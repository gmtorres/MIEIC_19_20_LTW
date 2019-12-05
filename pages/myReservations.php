<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getRents.php');
    include_once ('../actions/displayRents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/myReservations.css"], [["../js/requests.js","defer"]]);

    $requests = getRentsByUser($_SESSION['userID']);

    displayReservations($requests);

    draw_footer();

?>