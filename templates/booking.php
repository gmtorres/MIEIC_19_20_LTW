<?php

    function drawRentSubmition($placeId,$userId){
        ?>
            <form method="post" action = '../actions/addBooking.php' >
            <input type = "hidden" name = "PlaceId" value = "<?= $placeId?>" />
            <input type = "hidden" name = "Tourist" value = "<?= $userId?>" />
            <label> Start date </label>
                <input type="date" name="startDate" placeholder="" required><br>
            <label> End date </label>
                <input type="date" name="endDate" placeholder="" required><br>
            <input type="submit" value="Rent">
            </form>
        <?php
    }


?>