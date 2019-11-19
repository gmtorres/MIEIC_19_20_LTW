<?php
    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/user_info.php');
  
    draw_header();

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
    draw_footer();
    
?>