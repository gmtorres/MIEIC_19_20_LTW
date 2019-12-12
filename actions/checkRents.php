<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');

    
    function checkRentFromTourist($rentId,$tourist){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from Rent where rentId = ? and tourist = ?');
        $stmt->execute(array($rentId,$tourist));
        $rent = $stmt->fetchAll();
        //print_r($user);
        if($rent == FALSE)
            return 0;
        return 1;
    }

    function checkRentFromOwner($rentId,$owner){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from Rent INNER JOIN PLACE on Rent.place = Place.placeId INNER JOIN USER on Place.placeOwner = ? where rentId = ? ');
        $stmt->execute(array($owner,$rentId));
        $rent = $stmt->fetchAll();
        //print_r($user);
        if($rent == FALSE)
            return 0;
        return 1;

    }

    function getRent($rentId){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select title,city,placeAddress,placeDescription,startDate,endDate,price , 
                                Owner.userId as ownerId ,Owner.userName as ownerName , Owner.profilePicture as ownerPic,
                                Tourist.userId as touristId ,Tourist.userName as touristName , Tourist.profilePicture as touristPic,*
                                from Rent as Rent
                                    INNER JOIN PLACE AS Place on Rent.place = Place.placeId 
                                    INNER JOIN User AS Owner on Place.placeOwner = Owner.userId
                                    INNER JOIN User AS Tourist on Rent.tourist = Tourist.userId 
                                where rentId = ? ');
        $stmt->execute(array($rentId));
        $rent = $stmt->fetch();
        return $rent;
    }

    function displayRent($rent,$tourist){
        //print_r($rent);
        ?>
        
        <section id='rent'>
            <div class='rentInfo'>
                <?php if($tourist == 0){ ?>
                <a href="../pages/user.php?id=<?= $rent['touristId'] ?>">
                    <div class='userInfo'>
                        <img src="../images/profile/<?= $rent['touristPic'] ?>" alt="tourist pic">
                        <h3><?= $rent['touristName'] ?> </h3>
                    </div>
                </a>
                <?php }else{ ?>
                <a href="../pages/user.php?id=<?= $rent['ownerId'] ?>">
                    <div class='userInfo'>
                        <img src="../images/profile/<?= $rent['ownerPic'] ?>" alt="owner pic">
                        <h3><?= $rent['ownerName'] ?> </h3>
                    </div>
                </a>
                <?php } ?>
                    
                <div class='placeInfo'>
                    <a href="../pages/house.php?id=<?= $rent['placeID'] ?>">
                    <h3><?= $rent['title'] ?> </h3>
                    </a>
                    <h3><?= $rent['city'] ?> </h3>
                    <h3><?= $rent['placeAddress'] ?> </h3>
                    <h3><?= $rent['placeDescription'] ?> </h3>
                </div>
                <div class='dates'>
                    <h3>From <?= $rent['startDate'] ?> </h3>
                    <h3>To <?= $rent['endDate'] ?> </h3>
                    <h3><?= $rent['price'] ?>€ </h3>
                </div>
            </div>
        </section> 

        <?php
    }

    function displayChat($rentId){
        ?>    
        <section id='rentChat'>
        </section>
        <?php
    }

    function chatForm(){
        ?>    
        <form id='chatForm' method='post'>
            <textarea id="chatTextForm" name="Comment" rows="10" cols="40" required="required"></textarea><br>
            <input id="submitMessage" type="submit" value="Add message">
        </form>
        <?php
    }
    

?>