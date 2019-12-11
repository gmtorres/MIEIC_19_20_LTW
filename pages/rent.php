<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/checkRents.php');

    if(!isset($_GET['id'])){
        header("Location: ../pages/homePage.php");
        exit;
    }
    $rentId = $_GET['id'];
    $tourist = checkRentFromTourist($rentId,$_SESSION['userId']);
    if(!(checkRentFromTourist($rentId,$_SESSION['userId']) | checkRentFromOwner($rentId,$_SESSION['userId']))){
        header("Location: ../pages/homePage.php");
    }
    $_SESSION['chatRentId'] =  $rentId;

    $rent=getRent($rentId);

    draw_headerArgs(["../css/headerBlack.css","../css/rent.css"], [["../js/sendRentMessage.js","defer"]]);


    displayRent($rent,$tourist);

    ?>
        <section id='chat'>
    <?php
    chatForm();
    
    displayChat($rentId);

    ?>
        </section>
    <?php

    draw_footer();
?>