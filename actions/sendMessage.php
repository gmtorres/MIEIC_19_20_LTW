<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    include_once ('../actions/generalChecks.php');

    if(!isRentFromUser($_SESSION['userId'],$_SESSION['chatRentId'])){
        echo json_encode(['error' => 'do not match']);
        exit;
    }

    // Current time
    $timestamp = date("Y-m-d H:i:s");

    // Get last_id
    $last_id = $_POST['last_id'];

    // Database connection
    $db = Database::instance()->db();

    if (isset($_POST['text'])) {
        // GET username and text
        $userId = $_SESSION['userId'];
        $text = validate_input($_POST['text']); 
        // Insert Message
        $stmt = $db->prepare("INSERT INTO RentMessage(rentID,userId,comment,commentDate) VALUES (?, ?, ?, ?)");
        $stmt->execute(array($_SESSION['chatRentId'], $userId, $text,$timestamp));
    }

    // Retrieve new messages
    $stmt = $db->prepare("SELECT * , RentMessage.userId = ? as isUser FROM RentMessage INNER JOIN User on RentMessage.userId = user.userId WHERE rentMessageID > ? and rentID = ? ORDER BY rentMessageID ASC");
    $stmt->execute(array($_SESSION['userId'],$last_id,$_SESSION['chatRentId']));
    $messages = $stmt->fetchAll();

    // In order to get the most recent messages we have to reverse twice
    //$messages = array_reverse($messages);

    // Add a time field to each message

    // JSON encode
    echo json_encode($messages);

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>