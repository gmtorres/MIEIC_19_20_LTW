<?php

    function drawRentSubmition($placeId,$userId,$rents , $availables){
        $_SESSION['placeToRent'] = $placeId;
        ?>
            <form id='rentForm' method="post" action = '../actions/addBooking.php' >
                <input type = "hidden" name = "csrf" value = "<?= $_SESSION['csrf']?>" />
                
                <myDatePicker id = 'dates' allowOverlaps='true' calcultatePrice='true'></myDatePicker>
                <script type="text/javascript" src='../js/calendar.js'> </script>
                <script>
                    let blocked = (<?php echo json_encode(getRentsArray($rents)) ?>) ;
                    let avail = <?php echo json_encode(getAvailabititiesArray($availables)) ?>;
                    createAllCalendars( blocked , avail );</script>
                <span class="error" aria-live="polite"></span>
                <input id="rentSubmission" type="submit" value="Rent">
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
    }

?>