<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../actions/getUserInfo.php');
    include_once ('../actions/getRents.php');


    if(!isset($_GET['id'])){ //se o Id nao estiver set entao irá mostrar a sua propria pagina

        if(isset($_SESSION['username'])){

            draw_headerArgs(["../css/headerBlack.css", "../css/user.css"], []);
            $userId = $_SESSION['userId'];

            $user_info = getUserInfo($userId);
            //drawUserInfo($user_info);

            drawMainUserMenu();
            ?>
            <section id='placesSection'>
            <h3> Your places </h3>
            <?php
            $user_places = getUserPlaces($userId);
            drawUserPlaces($user_places);
            ?>
            </section>
            <?php

        }else{ //se a sessao nao esta iniciada ira fazer redirect
            $_SESSION['redirect'] = '../pages/user.php';
            header('Location: ../pages/homePage.php');
            exit;
        }
    }else{
        draw_headerArgs(["../css/headerBlack.css", "../css/user.css"], []);
        $userId = $_GET['id'];

        $user_info = getUserInfo($userId);
        if($user_info == null){
            unknownPage();
            exit;
        }
        drawUserInfo($user_info);
        ?>
        <section id='placesSection'>
        <h3> <?=$user_info['userName']?>'s places </h3>
        <?php
        $user_places = getUserPlaces($userId);
        drawUserPlaces($user_places);
        ?>
            </section>
        <?php
    }

    draw_footer();

?>