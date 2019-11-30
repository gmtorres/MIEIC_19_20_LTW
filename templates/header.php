<?php

    function draw_header(){  ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <title>My Project</title>
                <meta charset="utf-8">
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
            <div class = "bar">
            <a href="../pages/homePage.php"> HOME </a>

            <?php
            if(isset($_SESSION['username']) ){
                ?>
                    <div id = "login">
                        <a href="user.php"> <?=$_SESSION['username']?> </a>
                        <h2> | </h2>
                        <a href="../actions/logout.php"> Logout </a>
                    </div>

                <?php
            }else{
                ?>
                    <div id = "login">
                        <a href="login.php"> Login </a>
                        <h2> | </h2>
                        <a href="register.php"> Register </a>
                    </div>
                <?php
            }
            ?>
            </div>
            <?php
    }

    function unknownPage(){

        ?>
            <h2> Page not found </h2>
            <h4> This page could be not working properly or is no longer available. </h4>
        <?php

    }

?>