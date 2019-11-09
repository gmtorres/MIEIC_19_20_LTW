<?php
    function draw_header(){  ?>
        <!DOCTYPE html>
        <html> 
            <head>
                <title>My Project</title>
                <meta charset="utf-8">
            </head>
            <body>

            <a href="homePage.php"> HOME </a>

            <?php
                if( isset($_SESSION['username']) ){
                    ?>
                        <div id = "login">
                            <a href="user.php"> <?=$_SESSION['username']?> </a>
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
?>