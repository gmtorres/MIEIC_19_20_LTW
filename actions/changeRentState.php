<?php

    include_once ('../includes/database.php');

    $rentId = $_GET['rentId'];
    $state = $_GET['state'];

    $db = Database::instance()->db();
    $stmt = $db->prepare('Update Rent set accepted = :state where rentId = :rentId');
    $stmt->bindParam(':rentId', $rentId);
    $stmt->bindParam(':state', $state);
    $stmt->execute();

    echo json_encode([$rentId , $state]);
?>