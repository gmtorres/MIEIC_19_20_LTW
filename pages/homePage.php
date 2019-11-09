<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../get_place_info.php');
    include_once ('../getUserInfo.php');
    
    draw_header();
    ?>
        <div>
            <img src="" alt="">
            <form>
                <h1>Book Now</h1>
                <label>Where:
                    <br>
                    <input type = "text" name = "Destiny" required = "required" placeholder="ex: Porto">
                </label>
                <br>
                <label>Price
                    <br>
                    <input type="range" min="0" max="2000" value="500" class="slider" id="myRange">
                </label>
                <br>
                <label>When
                    <br>
                    <input type="date" name="startDate">
                    <br>
                    <input type="date" name="endDate">
                </label>
                <br>
                <label>Guests
                    <br>
                    <input type = "text" name = "guests" required = "required" placeholder="ex: 1">
                </label>
            </form>
        </div>
        <div>
            <h1>Top Picks</h1>
        </div>
        <div>
            <h1>Categories</h1>
        </div>

    <?php
    draw_footer();

?>