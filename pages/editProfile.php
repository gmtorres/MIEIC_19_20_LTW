<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/user_info.php');
  
    draw_headerArgs(["../css/headerBlack.css", "../css/editProfile.css"], []);

    if(!isset($_GET['id'])){

        if(isset($_SESSION['username'])){
        
            $userId = $_SESSION['userID'];
        
            $user_info = getUserInfo($userId);
        
        }else{
            $_SESSION['redirect'] = '../pages/user.php';
            header('Location: ../pages/login.php');
        }
    }

?>

    <div>
        <h1>Profile</h1>
    </div>
    
<?php  

    drawUserInfo($user_info);
    
?>

    <div>
        <form>
            <label> Change username:
                <br> <input type = "text" name = "username" placeholder="ex: marianaLima" >
            </label>
                <br>
            <label> Change password:
                <br> <input type = "text" name = "password" placeholder="ex: 123dzcbl" >
            </label>
                <br>
            <label> Change email:
                <br> <input type = "text" name = "email" placeholder="ex: marianaL@gmail.com" >
            </label>
                <br>
            <label> Change age:
                <br> <input type = "text" name = "age" placeholder="ex: 31" >
            </label>
                <br>
        </form>
    </div>

<?php  

    draw_footer();
    
?>