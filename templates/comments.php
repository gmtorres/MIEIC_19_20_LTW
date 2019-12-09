<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/getUserInfo.php');

    function drawCommentsSubmition($place, $writer){
    ?>
        <form id='commentForm' method="post" action = '../actions/addComment.php' >
            <input type = "hidden" name = "PlaceId" value = "<?= $place?>" />
            <input type = "hidden" name = "WriterId" value = "<?= $writer?>" />
                <input type = "text" name = "Title" required = "required" placeholder="Title"><br>
                <textarea name="Comment" rows="10" cols="40"></textarea><br>
            <label>Classification:
                <input type = "number" min='1' max='5' name = "Classification" required = "required" placeholder="3"><br>
            </label>
            <input id="submitComment" type="submit" value="Add comment">
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
            <section id='Comments'>
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
            <div class='comment'>
                <div class='commentInfo'>
                    <div id='commentUserPicture'>
                        <a href="user.php?id=<?=$comment['writer']?>"> 
                            <img src="../images/profile/<?=$profilePic?>.jpg"> 
                        </a>
                    </div>
                    <a href="./user.php?id= <?= $comment['writer'] ?> ">
                        <h5> <?= $userName ?> </h5>
                    </a>
                    <h3> <?= $comment['classification'] ?>  </h3>
                </div>
                <div class='commentText'>
                    <div class='commentHeader'>
                        <h3 class='commentTitle'> <?= $comment['title'] ?>  </h3>
                        <h3 class='commentDate'> <?= $comment['commentDate'] ?>  </h3>
                    </div>
                    <h4 > <?= $comment['comment'] ?>  </h4>
                </div> 
            </div>
        <?php   
        }
        ?>
            </section>
        <?php

    }

?>