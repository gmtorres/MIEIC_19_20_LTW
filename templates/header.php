<?php
    include_once ('../actions/getUserInfo.php');

    function draw_header(){  ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <title>My Project</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
                <link href="../css/style.css" rel="stylesheet">
            </head>
            <body>

            <?php
            draw_body();
    }

    function draw_headerArgs($cssFile, $jsFiles){  ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <title>My Project</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
                <link href="../css/style.css" rel="stylesheet">
                
                <?php
                foreach($cssFile as $css){
                    ?>
                        <link href="<?= $css ?>" rel="stylesheet">
                    <?php
                }
                ?>
                
                <?php
                foreach($jsFiles as $js){
                    if($js[1] == "async"){
                    ?>  
                        <script src="<?= $js[0] ?>" async ></script>
                    <?php
                    }else{
                    ?>  
                        <script src="<?= $js[0] ?>" defer ></script>
                    <?php
                    }
                }
                ?>

            </head>
            <body>

            <?php 
            draw_body();
    }
    
    function draw_body(){
        ?>
        <body>
        <div id="page-container">
        <div id="content-wrap">
            <div class = "bar">
            <a href="../pages/homePage.php"> Home </a>

            <?php
            if(isset($_SESSION['username']) ){
                $profilePic = getProfilePic($_SESSION['userId']);
                ?>
                    <div id = "login">
                        <div id='profilePicture'>
                            <a href="user.php"> 
                                <img src="../images/profile/<?=$profilePic?>.jpg"> 
                            </a>
                        </div>
                        <a href="user.php" class='barText'> <?=$_SESSION['username']?> </a>
                        <h2> | </h2>
                        <a href="../actions/logout.php" class='barText'> Logout </a>
                    </div>

                <?php
            }else{
                ?>
                    <div id = "login">
                        <a href="login.php" class='barText'> Login </a>
                        <h2> | </h2>
                        <a href="register.php" class='barText'> Register </a>
                    </div>
                <?php
            }
            ?>
            </div>
            <div id='pageContent'>
            <?php
    }

    function unknownPage(){

        ?>  <div>
                <h2> Page not found </h2>
                <h4> This page is not working properly or is no longer available. </h4>
            </div>
        <?php

    }

    function drawSearchForm(){
        $Destiny = null; if(isset($_GET['Destiny']) && !empty($_GET['Destiny'])) $Destiny = $_GET['Destiny'];
        $startDate = null; if(isset($_GET['startDate']) && !empty($_GET['startDate'])) $startDate = $_GET['startDate'];
        $endDate = null; if(isset($_GET['endDate']) && !empty($_GET['endDate'])) $endDate = $_GET['endDate'];
        $PriceRange = null; if(isset($_GET['PriceRange']) && !empty($_GET['PriceRange'])) $PriceRange = $_GET['PriceRange'];
        $guests = null; if(isset($_GET['guests']) && !empty($_GET['guests'])) $guests = $_GET['guests'];
        ?>
        <div id = booking>
            <form method="get" action="../pages/search.php">
                    <h1>Book Now</h1>
                    <label>Where:
                        <br><br> <input type = "text" name = "Destiny" required = "required" placeholder="ex: Porto" value=<?=$Destiny?>>
                    </label>
                    <br><br>
                    <label>Price
                        <br><br> <input type="range" name = 'PriceRange' min="0" max="3000" class="slider" id="PriceRange" value=<?=$PriceRange?>>
                        <p>Max. Price: <span id="range"></span> €</p>
                    </label>
                    <br>
                    <label>When
                        <br><br>
                        <myDatePicker id = 'dates' allowOverlaps='true' calcultatePrice='false' startDate='<?=$startDate?>' endDate='<?=$endDate?>'></myDatePicker>
                        <script type="text/javascript" src='../js/calendar.js'> </script>
                        <script>
                            createAllCalendars();</script>
                        <span class="error" aria-live="polite"></span>
                    </label>
                    <br><br>
                    <label>Guests
                        <br><br> <input type = "text" name = "guests" placeholder="ex: 1" value=<?=$guests?>> 
                    </label>
                    <input type="submit" value="Search">
                </form>
            </div>
            <?php
    }
?>