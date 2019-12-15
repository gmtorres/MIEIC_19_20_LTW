<?php
    include_once ('../includes/database.php');
    include_once ('../includes/session.php');

    $db = Database::instance()->db();

    $stmt = $db->prepare("Select profilePicture from User where userId = ?");
    $stmt->execute(array($_SESSION['userId']));
    $pic = $stmt->fetch();

    if($pic !== FALSE || $pic['profilePicture'] !== null ){
        if(file_exists('../images/profile/'. $pic['profilePicture'] . '.jpg'))
            unlink('../images/profile/'. $pic['profilePicture'] . '.jpg');
    }

    // Insert image data into database

    do {
        $picturePath = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 32)), 0, 32);

        $stmt = $db->prepare('Select * from User where profilePicture = ?');
        $stmt->execute(array($picturePath));
        
    } while ($stmt->fetch() != FALSE);

    $stmt = $db->prepare("Update User set profilePicture = ? where userId = ? ");
    $stmt->execute(array($picturePath,$_SESSION['userId']));

    //if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG)
        $originalFileName = '../images/profile/'. $picturePath . '.jpg';
    

    // Move the uploaded file to its final destination
    move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

    header("Location: ../pages/editProfile.php")

?>