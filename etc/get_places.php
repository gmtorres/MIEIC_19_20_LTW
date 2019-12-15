<?php

  include_once ('../includes/database.php');

  $db = Database::instance()->db();

  $stmt = $db->prepare('SELECT * FROM User');
  $stmt->execute();
  $users = $stmt->fetchAll();

  foreach( $users as $user) {
      echo '<h1>' . $user['userName'] . '</h1>';
      echo '<p>' . $user['email'] . '</p>';
  }

?>