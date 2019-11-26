<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getRents.php');
    include_once ('../actions/rents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs([],[["../js/requests.js","defer"]]);

    ?>
    <div class="w3-bar w3-black">
        <button class="w3-bar-item w3-button" onclick="getAllRents(<?= $_SESSION['userID']?>)">All</button>
        <button class="w3-bar-item w3-button" onclick="getRentsForAproval(<?= $_SESSION['userID']?>)">To approve</button>
        <button class="w3-bar-item w3-button" onclick="getRentsInNextTimes(<?= $_SESSION['userID']?>,1)">Today</button>
        <button class="w3-bar-item w3-button" onclick="getRentsInNextTimes(<?= $_SESSION['userID']?>,7)">1 week to go</button>
        <button class="w3-bar-item w3-button" onclick="getRentsInNextTimes(<?= $_SESSION['userID']?>,31)">1 month to go</button>
    </div> 

    <div id='rents'>
    </div>
    <?php
    


    draw_footer();


?>