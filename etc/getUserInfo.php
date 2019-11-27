<?php 
    
    function getUserInfo ($user_id){
        $db = new PDO('sqlite:../database.db');

        $stmt = $db->prepare('Select * from Place 
                            JOIN User 
                            where user.userid = place.placeOwner 
                            and placeid = :user_id');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $users = $stmt->fetchAll();
        
        foreach($users as $user) {   ?>

            <h1> <?=$user['userName']?> </h1>
            <h3> <?=$user['email']?> </h3>
            <h4> <?=$user['phoneNumber']?> </h4>
            <h5> <?=$user['age']?> </h5>
        
        <?php   }
        
        }   ?>
    