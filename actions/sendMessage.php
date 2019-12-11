<?php

    include_once ('../includes/session.php');
    include_once ('../includes/database.php');
    // Current time
    $timestamp = date("Y-m-d");

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
    $stmt = $db->prepare("SELECT * FROM RentMessage INNER JOIN User on RentMessage.userId = user.userId WHERE rentMessageID > ? ORDER BY rentMessageID ASC");
    $stmt->execute(array($last_id));
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