<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/getUserInfo.php');

    function drawCommentsSubmition($place, $writer){
    ?>
        <form method="post" action = '../actions/addComment.php' >
            <input type = "hidden" name = "PlaceId" value = "<?= $place?>" />
            <input type = "hidden" name = "WriterId" value = "<?= $writer?>" />
            <label>Title:
                <input type = "text" name = "Title" required = "required" placeholder="ex: My Stay"><br>
            </label>
            <label>Comment:
                <textarea name="Comment" rows="20" cols="80"></textarea><br>
            </label>
            <label>Classification:
                <input type = "number" name = "Classification" required = "required" placeholder="3"><br>
            </label>
            <input type="submit" value="Submit">
        </form>


    <?php
    }

    function drawComments($placeId){

        $comments = getComments($placeId);
        displayComments($comments);

    }

    function getComments($placeId){
        $db = Database::instance()->db();

        $stmt = $db->prepare('Select * from Comment where placeId = :placeId');
        $stmt->bindParam(':placeId' , $placeId);
        $stmt->execute();
        $comments = $stmt->fetchAll();

        return $comments;
    }

    function displayComments($comments){
        ?>
            <div id='Comments'>
            <h2>Comments </h2>
        <?php
        if(count($comments) == 0){
            ?>
            <h3> This house has no comments yet. </h3>
            <?php
        }
        foreach($comments as $comment){
            $userName = getUserInfo($comment['writer'])['userName'];
            $profilePic = getProfilePic($comment['writer']);
        ?>  
            <div id='Comment'>
                <h3> <?= $comment['title'] ?>  </h3>
                <div id='commentUserPicture'>
                    <a href="user.php?id=<?=$comment['writer']?>"> 
                        <img src="../images/profile/<?=$profilePic?>.jpg"> 
                    </a>
                </div>
                <a href="./user.php?id= <?= $comment['writer'] ?> ">
                    <h5> <?= $userName ?> </h5>
                </a>
                <h3> <?= $comment['classification'] ?>  </h3>
                <h4> <?= $comment['comment'] ?>  </h4>

            </div>
        <?php   
        }
        ?>
            </div>
        <?php

    }

?>