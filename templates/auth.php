<?php

    function draw_login(){
    ?>

        <header><h2>Ready for a booking?</h2></header>

        <form method="post" action="../actions/check_login.php">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="submit" value="Login">
        </form>

        <footer>
        <p>Don't have an account? Let's create one!</p>  <a href="register.php">Register!</a>
        </footer>

        <?php
    }
?>

<?php

    function draw_register(){
    ?>

        <header><h2>Join us!</h2></header>

        <form method="post" action="../actions/register.php">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="text" name="phoneNumber" placeholder="phoneNumber" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="text" name="age" placeholder="age" required>
            <input type="submit" value="Register">
        </form>

    <footer>
      <p>Already have an account? <a href="login.php">Login!</a></p>
    </footer>

        <?php
    }
?>