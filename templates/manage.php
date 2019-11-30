<?php

    include_once ('../actions/user_info.php');

    function draw_manager(){

    ?>

        <ul>
            <li> <a href="../pages/addPlace.php" > Add place </a> </li>
            <li> <a href="" > Settings </a> </li>

        </ul>

        
    <?php
        $userId = $_SESSION['userID'];
        $user_places = getUserPlaces($userId);
        drawUserPlacesManager($user_places);

    }

    function drawUserPlacesManager($places){
        if(count($places) == 0){
            ?>
            <h3> This user has no places to rent. </h3>
            <?php
        }
        foreach($places as $place){
            ?>  
                <a href="./houseManage.php?id=<?= $place['id']?>" >
                    <div id='UserPlace '>
                        <h3> <?= $place['title']?> </h3>
                        <h4> <?= $place['class']?> </h4>
                        <h4> <?= $place['area']?> </h4>
                        <h5> <?= $place['placeDescription']?> </h5>
                    </div>
                </a>
            <?php
        } 
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
?>