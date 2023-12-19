<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) {
    header('Location: /');
    exit;
  }

  require_once(__DIR__ . '/../database/db_connection.db.php');
  require_once(__DIR__ . '/../database/users.class.php');

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if ($user) {
    $user->name = $_POST['Uname'];
    $user->email = $_POST['Email'];
    if($_POST['Password1'] == $_POST['Password2']){
      $user->password = password_hash($_POST['Password1'], PASSWORD_DEFAULT);
      $_SESSION['profileUpdateStatus'] = 'Profile updated successfully!';
    } else{
      $_SESSION['profileUpdateStatus'] = 'Passwords don\'t match!';
    }
    
    $user->save($db);
    $session->setName($user->name());
  }

  header('Location: ../pages/profile.php');
  exit;

  //editar o perfil
?>

