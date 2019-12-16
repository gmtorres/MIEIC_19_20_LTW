<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getHotPicks.php');

    draw_headerArgs(["../css/header.css", "../css/homePage.css" , "../css/calendar.css"], [["../js/slider.js","defer"]]);

    ?>
    

    <div id = imageContainer>
        
    <?php
        drawSearchForm();
    ?> 
    
    </div>
    <div id = topPicks>
        <h1>Top Picks</h1>
        <div id = topPicksT>
            <?php
                drawHotPicks();
            ?>
        </div>
    </div>
    <!--<div id = categories>
        <h1>Categories</h1>
    </div>-->

    <?php
    draw_footer();

?>