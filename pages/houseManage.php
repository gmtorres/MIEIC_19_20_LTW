<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');
    include_once ('../actions/get_place_info.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    $userId = $_SESSION['userID'];
    $user_places = getUserPlaces($userId);

    $houseID = $_GET['id'];
    $Userplace = NULL;
    foreach($user_places as $place){
        if($place['id'] == $houseID){
            $Userplace = $place;
            break;
        }
    }
    if($Userplace == NULL)
        header('Location: ../pages/manage.php');

    

    draw_header();

    drawPlace($place);

    $availables = getAvailabitities($Userplace['id']);

    drawAvailables($availables);
    ?>
        <label> Add availabity </label>
        <form method="post" action="../actions/addAvailability.php">
            <input type = "hidden" name = "placeId" value = "<?= $Userplace['id']?>" />
            
            <myDatePicker allowOverlaps="true" ></myDatePicker>
            <script type="text/javascript" src='../js/calendar.js'> </script>
            
            <script>
                createAllCalendars( <?php echo json_encode(getAvailabititiesArray($availables)) ?>);
            </script>

            <label> Price per night </label>
                <input type="number" name="price" placeholder="" required><br>
            <input type="submit" value="Submit">
        </form>

    <?php
    

    draw_footer();


?>