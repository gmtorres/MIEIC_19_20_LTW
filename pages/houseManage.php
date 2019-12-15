<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');
    include_once ('../actions/getPlaceInfo.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    $userId = $_SESSION['userId'];
    $user_places = getUserPlaces($userId);

    $houseID = $_GET['id'];
    $userplace = NULL;
    foreach($user_places as $place){
        if($place['id'] == $houseID){
            $userplace = $place;
            break;
        }
    }
    if($userplace == NULL)
        header('Location: ../pages/manage.php');
    
    draw_headerArgs(["../css/headerBlack.css", "../css/calendar.css","../css/slideshow.css", "../css/houseManage.css"], 
    [["../js/editAvailables.js", "defer"],['../js/slideshow.js','defer'],['../js/removeImage.js','defer'],['../js/formChecks.js','defer'],['../js/changeExtras.js','defer']]);

    drawPlaceManager($place);

    ?>
    <div id='extrasDiv'>
        <?php drawExtrasForm($houseID); ?>
    </div>
    <?php

    drawAddPictureForm($userplace);

    $images = getPlaceImages($userplace['id']);
    displayPlaceImagesRemove($images);

    drawAvailablesForm($userplace);

    draw_footer();


?>