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

    

    draw_headerArgs(["../css/calendar.css"] , []);

    drawPlace($place);

    $availables = getAvailabitities($Userplace['id']);

    drawAvailables($availables);
    ?>
        <label> Add availabity </label>
        <form method="post" action="../actions/addAvailability.php">
            <input type = "hidden" name = "placeId" value = "<?= $Userplace['id']?>" />
            
            <myDatePicker id ="dates" allowOverlaps="true" required="required"></myDatePicker>
            <script type="text/javascript" src='../js/calendar.js'> </script>
            
            <script>
                createAllCalendars( <?php echo json_encode(getAvailabititiesArray($availables)) ?>);

            </script>

            <label> Price per night </label>
                <input type="number" name="price" placeholder="" required><br>
            <span class="error" aria-live="polite"></span>
            <input type="submit" value="Submit">
        </form>
        <script>
            var form  = document.getElementsByTagName('form')[0];
            var dates = document.getElementById('dates');
            var error = document.querySelector('.error');

            dates.addEventListener("input", function (event) {
                error.innerHTML = ""; // Reset the content of the message
                error.className = "error"; // Reset the visual state of the message
            },false);

            form.addEventListener("submit" , function(event){

                var inicial = document.getElementById('input_0_start');
                var final = document.getElementById('input_0_end');
                
                if( !inicial.validity.valid || !final.validity.valid || inicial.value == "" || final.valid == ""){
                    error.innerHTML = "Please fill all fields.";
                    error.className = "error active";
                    event.preventDefault(); 
                }
            },false);
        </script>

    <?php
    

    draw_footer();


?>