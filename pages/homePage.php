<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getHotPicks.php');

    draw_headerArgs(["../css/header.css", "../css/homePage.css" , "../css/calendar.css"], []);

    ?>
    

    <div id = imageContainer>
        
    <?php

    ?>
        <div id = booking>
            <form method="get" action="../pages/search.php">
                <h1>Book Now</h1>
                <label>Where:
                    <br><br> <input type = "text" name = "Destiny" required = "required" placeholder="ex: Porto">
                </label>
                <br><br>
                <label>Price
                    <br><br> <input type="range" name = 'PriceRange' min="0" max="2000" value="500" class="slider" id="PriceRange">
                </label>
                <br>
                <label>When
                    <myDatePicker id = 'dates' allowOverlaps='true' calcultatePrice='false'></myDatePicker>
                    <script type="text/javascript" src='../js/calendar.js'> </script>
                    <script>
                        createAllCalendars();</script>
                    <span class="error" aria-live="polite"></span>
                </label>
                <br><br>
                <label>Guests
                    <br><br> <input type = "text" name = "guests" placeholder="ex: 1"> 
                </label>
                <input type="submit" value="Search">
            </form>
        </div>    
    </div>
    <div id = topPicks>
        <h1>Top Picks</h1>
        <div id = topPicksT>
            <?php
                drawHotPicks();
            ?>
        </div>
    </div>
    <div id = categories>
        <h1>Categories</h1>
    </div>

    <?php
    draw_footer();

?>