<?php

    include_once ('../actions/user_info.php');

    

    function draw_manager(){

    ?>

        <ul>
            <li> <a href="../pages/addPlace.php" > Add place </a> </li>
            <li> <a href="" > Settings </a> </li>

        </ul>



    <?php

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