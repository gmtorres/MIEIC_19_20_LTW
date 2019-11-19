<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
  
    draw_header();

    ?>

        <div>
            <h1>Settings</h1>
        </div>
        <nav id=menu>
            <ul>
                <il><a href="profile.php">Profile</a></li>
                <il><a href="account.php">Account</a></li>
                <il><a href="manageHouses.php">Manage Houses</a></li>
                <il><a href="history.php">History</a></li>
            </ul>
        </nav>

    <?php
    draw_footer();
    
?>