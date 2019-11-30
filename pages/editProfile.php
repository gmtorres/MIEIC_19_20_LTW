<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/user_info.php');

    if(!isset($_GET['id'])){

        if(isset($_SESSION['username'])){
        
            $userId = $_SESSION['userID'];
        
            $user_info = getUserInfo($userId);
        
        }else{
            $_SESSION['redirect'] = '../pages/user.php';
            header('Location: ../pages/login.php');
        }
    }
    $_SESSION['username'] = getUserInfo($_SESSION['userID'])['userName'];

    draw_headerArgs(["../css/headerBlack.css", "../css/editProfile.css"], [["../js/editProfile.js","defer"]]);

?>

    <div>
        <h1>Profile</h1>
    </div>
    
<?php  

    drawUserInfo($user_info);
    
?>

    <div>
        <form id="changeUserName">
            <h3> Change username </h3>
            <label> New username:
                <br> <input type = "text" name = "username" placeholder="ex: marianaLima" required>
            </label><br>
            <span></span>
            <button type='submit'> Change username </button>
        </form>
        <form id="changePassword">
            <h3> Change password </h3>
            <label> Old password:
                <br> <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <label> New password:
                <br> <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <label> Repeat new password:
                <br> <input type = "password" name = "password" placeholder="ex: 123dzcbl" required>
            </label><br>
            <span></span>
            <button type='submit'> Change password </button>
        </form>
        <form id='changeEmail'>
            <h3> Change email </h3>
            <label> Old email:
                <br> <input type = "email" name = "email" placeholder="ex: ritaLima@gmail.com" required>
            </label><br>
            <label> New email:
                <br> <input type = "email" name = "email" placeholder="ex: rita_lima@hotmail.com" required>
            </label><br>
            <span></span>
            <button type='submit'> Change email </button>
        </form>
        <form id='changeProfilePic' action="../actions/changeProfilePicture.php" method="post" enctype="multipart/form-data">
            <h3> Change Profile picture </h3>
            <label> New image:
                <br> <input type="file" name="image" required>
            </label><br>
            <span></span>
            <button type='submit'> Change picture </button>
        </form>


    </div>



<?php  

    draw_footer();
    
?>