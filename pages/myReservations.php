<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getRents.php');
    include_once ('../actions/displayRents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/myReservations.css"], [["../js/requests.js","defer"]]);

    ?>
        <div id="options">
        <ul>
        <li class="request_button" onclick="getRentsByUserInPast(<?= $_SESSION['userId']?>,0)"> <a>Past rents</a></li>
        <li class="request_button" onclick="getRentsByUserAproved(<?= $_SESSION['userId']?>,1)"><a>Next stays</a></li>
        <li class="request_button" onclick="getRentsByUserWaiting(<?= $_SESSION['userId']?>,2)"><a>Waiting for answer</a></li>
        <li class="request_button" onclick="getRentsByUser(<?= $_SESSION['userId']?>,3)"><a>All</a></li>
        <script>
            window.onload = function(){ 
                getRentsByUserAproved(<?= $_SESSION['userId']?>,1);
            }
        </script>
    </div> 
    <section id='requests'>
        <h3 id='title'> My Requests </h3>
        <section id='rents'>
        </section>
    </section>
    <?php


    draw_footer();

?>