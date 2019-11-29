<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/user_info.php');

    draw_headerArgs(["../css/headerBlack.css", "../css/user.css"], []);

    if(!isset($_GET['id'])){ //se o Id nao estiver set entao irá mostrar a sua propria pagina

        if(isset($_SESSION['username'])){

            $userId = $_SESSION['userID'];

            $user_info = getUserInfo($userId);
            //drawUserInfo($user_info);

            drawMainUserMenu();
            
            $user_places = getUserPlaces($userId);
            drawUserPlaces($user_places);

        }else{ //se a sessao nao esta iniciada ira fazer redirect
            $_SESSION['redirect'] = '../pages/user.php';
            header('Location: ../pages/login.php');
        }
    }else{
        $userId = $_GET['id'];

        $user_info = getUserInfo($userId);
        drawUserInfo($user_info);

        $user_places = getUserPlaces($userId);
        drawUserPlaces($user_places);
    }

    draw_footer();

?>