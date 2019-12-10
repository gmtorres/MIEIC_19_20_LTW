<?php

function draw_login()
{
    ?>

    <div class="modal" id = "loginModal">
        <div class="modalContent animate">
            <div id=formBlock>

                <header>
                    <h2>Ready for your first booking?</h2>
                </header>

                <span onclick="document.getElementById('loginModal').style.display='none'" class="close" title="Close login window">&times;</span>

                <?php
                    if (isset($_SESSION['login_message'])) {
                        ?>
                    <h4> <?= $_SESSION['login_message'] ?> <h4>
                        <?php
                                unset($_SESSION['login_message']);
                            }
                            ?>

                        <form method="post" action="../actions/check_login.php">
                            <input type="text" name="username" placeholder="Username" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <input type="submit" value="Login">
                        </form>

                        <footer>
                            <p>Don't have an account? Let's create one! 
                            <button onclick="document.getElementById('loginModal').style.display='none';
                            document.getElementById('registerModal').style.display='flex'">Register</button>
                            </p>
                        </footer>

            </div>
        </div>
    </div>

<?php
}
?>

<?php

function draw_register()
{
    ?>
    <div class="modal" id = "registerModal">
        <div class="modalContent animate">
            <div id=formBlock>

                <header>
                    <h2>Join us!</h2>
                </header>
                <span onclick="document.getElementById('registerModal').style.display='none'" class="close" title="Close register window">&times;</span>

                <?php
                    if (isset($_SESSION['register_message'])) {
                        ?>
                    <h4> <?= $_SESSION['register_message'] ?> <h4>
                        <?php
                                unset($_SESSION['register_message']);
                            }
                            ?>

                        <form id='register' method="post" action="../actions/register.php">
                            <input type="text" name="username" placeholder="Username" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <input type="password" name="password" placeholder="Confirm password" required>
                            <input type="text" name="phoneNumber" placeholder="Phone Number" required>
                            <input type="email" name="email" placeholder="E-mail" required>
                            <input type="text" name="age" placeholder="Age" required>
                            <input type="submit" value="Register"><br>
                            <span></span>
                        </form>

                        <footer>
                            <p>Already have an account? 
                            <button onclick="document.getElementById('registerModal').style.display='none';
                            document.getElementById('loginModal').style.display='flex'">Login</button>
                            </p>
                        </footer>

            </div>
        </div>
    </div>

<?php
}
?>