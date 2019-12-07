<?php

    include_once ('../includes/session.php');
    include_once ('../templates/header.php');
    include_once ('../templates/footer.php');
    include_once ('../templates/manage.php');
    include_once ('../actions/getPlaceInfo.php');

    if(!isset($_SESSION['username']))
        header('Location: ../pages/homePage.php');

    $userId = $_SESSION['userID'];
    $user_places = getUserPlaces($userId);

    $houseID = $_GET['id'];
    $userplace = NULL;
    foreach($user_places as $place){
        if($place['id'] == $houseID){
            $userplace = $place;
            break;
        }
    }
    if($userplace == NULL)
        header('Location: ../pages/manage.php');
    
    draw_headerArgs(["../css/headerBlack.css", "../css/calendar.css","../css/slideshow.css"], [["../js/editAvailables.js", "defer"],['../js/slideshow.js','defer'],['../js/removeImage.js','defer']]);

    drawPlaceManager($place);

    drawAddPictureForm($userplace);

    $images = getPlaceImages($userplace['id']);
    displayPlaceImagesRemove($images);

    drawAvailablesForm($userplace);
    ?>
    <div id='teste'>
    
    </div>
    <?php
    draw_footer();

    ?>

        <script>

            function testAjax(){
                let request = new XMLHttpRequest();
                request.open('post', '../actions/a_test.php' , true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                request.addEventListener('load', test);
                request.send(encodeForAjax({"test" : 1}));
            }

            function test(){
                //let data = JSON.parse(this.responseText);
                console.log(this.responseText);
                document.getElementById('teste').innerHTML = this.responseText;

            }

            function encodeForAjax(data) {
                return Object.keys(data).map(function(k){
                return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
                }).join('&');
            }

            //testAjax();

        </script>

    <?


?>