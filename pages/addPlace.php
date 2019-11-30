<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

<<<<<<< HEAD
    draw_headerArgs([],[['../js/addPlaceOptions.js','defer']]);

=======
    draw_headerArgs(["../css/headerBlack.css", "../css/addPlace.css"], []);
>>>>>>> e25ef3da00ab53c8fee0634c5eeaed5ddc0c88e3
    draw_addPlace();
    draw_footer();

?>