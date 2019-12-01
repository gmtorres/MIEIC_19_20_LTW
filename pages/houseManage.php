<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');
    include_once ('../actions/getPlaceInfo.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    $userId = $_SESSION['userID'];
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
    
    draw_headerArgs(["../css/headerBlack.css", "../css/calendar.css"], [["../js/addAvailables.js", "defer"],["../js/editPlace.js", "defer"]]);

    drawPlaceManager($place);

    drawAddPictureForm($userplace);

    $images = getPlaceImages($userplace['id']);
    displayPlaceImages($images);

    drawAvailablesForm($userplace);

    
    draw_footer();

?>