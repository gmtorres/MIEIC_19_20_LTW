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
            <input type="text" name="Title" placeholder="Title" required>
            <input type="text" name="Zone" placeholder="Zone" required>
            <input type="text" name="Address" placeholder="Address" required>
            <br>
            <textarea name="Description" rows="40" cols="30"></textarea>
            <br>
            <input type="text" name="maxGuests" placeholder="Max Guests" required>
            <input type="submit" value="Submit">
        </form>

        <?php

    }


?>