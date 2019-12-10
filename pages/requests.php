<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getRents.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/requests.css"],[["../js/requests.js", "defer"]]);

    ?>
    <div id="options">
        <ul>
            <li class="request_button" onclick="getRentsInFuture(<?= $_SESSION['userId']?>,0)"> <a>In Future</a></li>
            <li class="request_button" onclick="getRentsForAproval(<?= $_SESSION['userId']?>,1)"><a>To approve</a></li>
            <li class="request_button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,1,2)"><a>Today</a></li>
            <li class="request_button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,7,3)"><a>1 week to go</a></li>
            <li class="request_button" onclick="getRentsInNextTimes(<?= $_SESSION['userId']?>,31,4)"><a>1 month to go</a></li>
            <li class="request_button" onclick="getAllRents(<?= $_SESSION['userId']?>,5)"><a>All</a></li>
        </ul>
        <script>
            window.onload = function(){ 
                getRentsForAproval(<?= $_SESSION['userId']?>,1);
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