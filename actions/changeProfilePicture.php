<?php
    include_once ('../includes/database.php');
    include_once ('../includes/session.php');

    $db = Database::instance()->db();

    $stmt = $db->prepare("Select profilePicture from User where userId = ?");
    $stmt->execute(array($_SESSION['userID']));
    $pic = $stmt->fetch();

    if($pic !== FALSE || $pic['profilePicture'] !== null ){
        if(file_exists('../images/profile/'. $_SESSION['userID'] . '.jpg'))
            unlink('../images/profile/'. $_SESSION['userID'] . '.jpg');
    }

    // Insert image data into database
    $stmt = $db->prepare("Update User set profilePicture = 1 where userId = ? ");
    $stmt->execute(array($_SESSION['userID']));

    //if(exif_imagetype($_FILES['image']['tmp_name']) == IMAGETYPE_JPEG)
        $originalFileName = '../images/profile/'. $_SESSION['userID'] . '.jpg';
    

    // Move the uploaded file to its final destination
    move_uploaded_file($_FILES['image']['tmp_name'], $originalFileName);

    header("Location: ../pages/editProfile.php")

?>