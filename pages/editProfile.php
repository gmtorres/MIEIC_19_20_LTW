<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getUserInfo.php');

    if(!isset($_GET['id'])){

        if(isset($_SESSION['username'])){
        
            $userId = $_SESSION['userId'];
        
            $user_info = getUserInfo($userId);
        
        }else{
            $_SESSION['redirect'] = '../pages/user.php';
            header('Location: ../pages/login.php');
        }
    }
    $_SESSION['username'] = getUserInfo($_SESSION['userId'])['userName'];

    draw_headerArgs(["../css/headerBlack.css", "../css/editProfile.css"], [["../js/editProfile.js","defer"]]);

?>

    <div>
        <h1>Profile</h1>
    </div>
    
<?php  

    drawUserInfo($user_info);
    
?>

    <div>
        
        <form class = "box" id = "changeUserName">
            <h3> Change Username </h3>
            <label> New username:
                <input type = "text" name = "username" placeholder="ex: marianaLima" required>
            </label><br>
            <span></span>
            <input class='csrf' type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button type='submit'> Change Username </button>
        </form>
        <form class = "box" id="changePassword">
            <h3> Change Password </h3>
            <label> Old password:
                <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <label> New password:
                 <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <label> Repeat new password:
                <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <span></span>
            <input class='csrf' type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button type='submit'> Change Password </button>
        </form>
        <form class = "box" id='changeEmail'>
            <h3> Change Email </h3>
            <label> Old email:
                <input type = "email" name = "email" placeholder="ex: ritaLima@gmail.com" required>
            </label><br>
            <label> New email:
                <input type = "email" name = "email" placeholder="ex: rita_lima@hotmail.com" required>
            </label><br>
            <span></span>
            <input class='csrf' type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button type='submit'> Change Email </button>
        </form>
        <form class = "box" id='changeProfilePic' action="../actions/changeProfilePicture.php" method="post" enctype="multipart/form-data">
            <h3> Change Profile Picture </h3>
            <label> New image:
                <input type="file" name="image" required>
            </label><br>
            <span></span>
            <input class='csrf' type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <button type='submit'> Change Picture </button>
        </form>

    </div>

<?php  

    draw_footer();
    
?>