<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getHotPicks.php');

    
    draw_header();
    ?>
        <div>
            <img src="" alt="">
            <form method="get" action="../pages/search.php">
                <h1>Book Now</h1>
                <label>Where:
                    <br> <input type = "text" name = "Destiny" required = "required" placeholder="ex: Porto">
                </label>
                <br>
                <label>Price
                    <br> <input type="range" name = 'PriceRange' min="0" max="2000" value="500" class="slider" id="PriceRange">
                </label>
                <br>
                <label>When
                    <br> <input type="date" name="startDate">
                    <br> <input type="date" name="endDate">
                </label>
                <br>
                <label>Guests
                    <br> <input type = "text" name = "guests" placeholder="ex: 1">
                </label>
                <input type="submit" value="Search">
            </form>
        </div>
        <div>
            <h1>Top Picks</h1>
            <?php
                drawHotPicks();
            ?>
        </div>
        <div>
            <h1>Categories</h1>
        </div>

    <?php
    draw_footer();

?>