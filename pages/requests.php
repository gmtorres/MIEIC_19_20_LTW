<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getRents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/requests.css"],[["../js/requests.js", "defer"]]);

    ?>
    <div class="w3-bar w3-black">
        <button class="request button" onclick="getRentsInFuture(<?= $_SESSION['userId']?>)">In Future</button>
        <button class="request button" onclick="getRentsForAproval(<?= $_SESSION['userId']?>)">To approve</button>
        <button class="request button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,1)">Today</button>
        <button class="request button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,7)">1 week to go</button>
        <button class="request button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,31)">1 month to go</button>
        <button class="request button" onclick="getAllRents(<?= $_SESSION['userId']?>)">All</button>
        <script>
            window.onload = function(){ 
                getRentsForAproval(<?= $_SESSION['userId']?>);
            }
        </script>
    </div> 

    <div id='rents'>
    </div>
    <?php
    
    draw_footer();

?>