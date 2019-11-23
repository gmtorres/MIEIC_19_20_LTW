<?php
    function draw_header(){  ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <title>My Project</title>
                <meta charset="utf-8">

                <link href="../css/calendar.css" rel="stylesheet">


            </head>
            <body>

            <a href="../pages/homePage.php"> HOME </a>


            <?php
                if( isset($_SESSION['username']) ){
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
                            <h2> / </h2>
                            <a href="register.php"> Register </a>
                        </div>

                    <?php
                }
            ?>
  
  <?php }

    function unknownPage(){

        ?>
            <h2> Page not found </h2>
            <h4> This page could be not working properly or is no longer available. </h4>
        <?php

    }

?>