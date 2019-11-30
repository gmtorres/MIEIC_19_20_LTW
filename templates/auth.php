<?php

    function draw_login(){
    ?>

    <div id = formBlock>

        <header><h2>Ready for your first booking?</h2></header>

        <?php
            if(isset($_SESSION['login_message'])){
                ?>
                    <h4> <?= $_SESSION['login_message'] ?> <h4>
                <?php
                unset($_SESSION['login_message']);
            }
        ?>

        <form method="post" action="../actions/check_login.php">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="submit" value="Login">
        </form>

        <footer>
        <p>Don't have an account? Let's create one! <a href="register.php">Register!</a> </p>
        </footer>

    </div>

        <?php
    }
?>

<?php

    function draw_register(){
    ?>
        <div id = formBlock>

        <header><h2>Join us!</h2></header>

        <?php
            if(isset($_SESSION['register_message'])){
                ?>
                    <h4> <?= $_SESSION['register_message'] ?> <h4>
                <?php
                unset($_SESSION['register_message']);
            }
        ?>

        <form method="post" action="../actions/register.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phoneNumber" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="age" placeholder="Age" required>
            <input type="submit" value="Register">
        </form>

        <footer>
        <p>Already have an account? <a href="login.php">Login!</a></p>
        </footer>

    </div>

        <?php
    }
?>