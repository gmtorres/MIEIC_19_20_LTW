<?php

    include_once ('../actions/getUserInfo.php');
    include_once ('../actions/getPlaceInfo.php');

    function draw_manager(){
        $number = count(getRentsByOwnerForApproval($_SESSION['userId']));
        if($number > 9) $number = "+9";
    ?>

        <div id="userMenu">
        <ul>
            <li> <a href="../pages/editProfile.php" > Edit Profile </a> </li>
            <li> <a href="../pages/addPlace.php" > Add Place </a> </li>
            <li> <a href="../pages/requests.php" > Requests
                <?php if($number != 0){ ?>
                    <span id='numberRequest'> <?=$number?> </span> 
                <?php }?>
                </a> </li>
            <li> <a href="../pages/myReservations.php" > My reservations </a> </li>

        </ul>
    </div>

        
    <?php
        $userId = $_SESSION['userId'];
        $user_places = getUserPlaces($userId);
        drawUserPlacesManager($user_places);

    }

    function drawUserPlacesManager($places){
        ?>
            <section id='placesSection'>
                <h3> Manage your places </h3>
        <?php
        if(count($places) == 0){
            ?>
            <h3> This user has no places to rent. </h3>
            <?php
        }
        foreach($places as $place){
            ?>  
                <a href="./houseManage.php?id=<?= $place['id']?>" >
                <div class='userPlace'><?php
                        $images = getPlaceImages($place['id']);
                        displayPlaceImage($images);?>
                        <div class='userPlaceInfo'>
                            <h2> <?= $place['title']?> </h2>
                            <h3>
                            <?php
                                if($place['class'] != 'No Reviews yet'){
                            ?>
                                Classification 
                            <?php
                                }   
                            ?>
                            <?= $place['class']?> </h3>
                            <h3> <?= $place['city']?> </h3>
                            <p> <?= $place['placeDescription']?> </p>
                        </div>
                    </div>
                </a>
            <?php
        } 
        ?>
            </section>
        <?php
    }

    function draw_addPlace(){

        ?>

        <form method="post" action="../actions/addPlace.php">
            <label> Place Title
                <input type="text" name="Title" placeholder="Title" required>
            </label>
            <label> Zone/City
                <input type="text" name="Zone" placeholder="Zone" required>
            </label>
            <label> Adress
                <input type="text" name="Address" placeholder="Address" required>
            </label>
            <label> Description
                <br>
                <textarea name="Description" rows="20" cols="100"></textarea>
                <br>
            </label>
            <label> Maximum Guests
                <input type="text" name="maxGuests" placeholder="Max Guests" required>
            </label>
            <div id='extras'>
                <h3>Extras</h3>
            </div>
            <input id='extraDescription' type="text" name="Extra" placeholder="Extra">
            <button onclick="appendExtra()" type="button"> Add extra </button>
            <div id='restrictions'>
                <h3>Restrictions</h3>
            </div>
            <input id='restrictionDescription' type="text" name="Restriction" placeholder="Restriction">
            <button onclick="appendRestriction()" type="button"> Add restriction </button>
            <br>
            <input type="submit" value="Add Place">
        </form>

        <?php

    }

    function drawPlaceManager($place){
        ?>

        <form id='changePlaceInfo' method="post" action='../actions/changePlaceInfo.php'>
            <input type="hidden" id="placeId" name="placeId" value=<?=$place['id']?>>
            <label> Place Title
                <input type="text" name="Title" placeholder="Title" value='<?=$place['title']?>' required>
            </label>
            <label> Zone/City
                <input type="text" name="Zone" placeholder="Zone" value='<?=$place['city']?>' required>
            </label>
            <label> Adress
                <input type="text" name="Address" placeholder="Address" value='<?=$place['placeAddress']?>' required>
            </label>
            <label> Description
                <br>
                <textarea name="Description" rows="20" cols="100"><?= $place['placeDescription'] ?></textarea>
                <br>
            </label>
            <label> Maximum Guests
                <input type="text" name="maxGuests" placeholder="Max Guests" value='<?=$place['maxGuests']?>' required>
            </label>
            <input type="submit" value="Change Place Info">
        </form>

        <?php
    }

    function drawAvailablesForm($place){
        $availables = getAvailabitities($place['id']);

    ?>
        <label> Add availabity </label>
        <form  id='AddAvailables' >
            <input type = "hidden" name = "placeId" value = "<?= $place['id']?>" />
            
            <myDatePicker id ="dates" allowOverlaps="true" required="required"></myDatePicker>
                <script type="text/javascript" src='../js/calendar.js'> </script>
                <script>
                    
                </script>

            <label> Price per night </label>
                <input id= 'price' type="number" name="price" placeholder="" required><br>
            <span class="error" aria-live="polite"></span>
            <input type="submit" value="Add dates">

        </form>

        <script>
            var calendar = createCalendar( <?php echo json_encode(getAvailabititiesArray($availables)) ?>);
            var form  = document.getElementById('AddAvailables');
            var dates = document.getElementById('dates');
            var error = document.querySelector('.error');

            dates.addEventListener("input", function (event) {
                error.innerHTML = ""; // Reset the content of the message
                error.className = "error"; // Reset the visual state of the message
            },false);

            form.addEventListener("submit" , function(event){

                var inicial = document.getElementById('input_0_start');
                var final = document.getElementById('input_0_end');
                var price = document.getElementById('price');
                
                if( !inicial.validity.valid || !final.validity.valid || inicial.value == "" || final.value == ""){
                    error.innerHTML = "Please fill all fields.";
                    error.className = "error active";
                    event.preventDefault(); 
                }else{
                    //console.log("a");
                    //inicial.value = null;
                    //final.value = "";
                    addAvailable(<?= $place['id'] ?> , inicial.value, final.value, price.value,calendarioRef );
                    event.preventDefault(); 
                }
            },false);
            
        </script>

    <?php
        drawAvailables($availables);
    }

    function drawAddPictureForm($place){
        ?>
            <form id='addPlacePicture' method='post' action='../actions/addPlacePicture.php' enctype="multipart/form-data">
                <input type="hidden" id="placeId" name="placeId" value=<?=$place['id']?> >
    
                <label> Add Picture
                    <br> <input type="file" name="image" required>
                </label> <br>
                <label> Place Description
                    <br> <input type="text" name="description" >
                </label>
                <input type="submit" value="Add Picture">
            </form>
        <?php
    }

?>