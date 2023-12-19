<?php 
  declare(strict_types = 1); 
//criar a página do perfil
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/db_connection.db.php');
  require_once(__DIR__ . '/../database/users.class.php');

  $session = new Session();

  if (!$session->isLoggedIn()) {
    header('Location: ../pages/index.php');
    exit;
  }

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

?>

<?php require_once(__DIR__ . '/../templates/common.tpl.php'); ?>

<?php drawHeader($session); ?>

<h2>Profile of <?php echo htmlspecialchars($session->getName()); ?></h2>


<?php
if (isset($_SESSION['profileUpdateStatus'])) {
    echo "<p class='profile-update-status'>{$_SESSION['profileUpdateStatus']}</p>";
    unset($_SESSION['profileUpdateStatus']);
}
?>

<h3>Your Details</h3>
<ul class="your-details">
  <li>Username: <?php echo htmlspecialchars($user->username); ?></li>
  <li>Name: <?php echo htmlspecialchars($user->name()); ?></li>
  <li>Email: <?php echo htmlspecialchars($user->email); ?></li>
</ul>

<h3>Edit Profile</h3>
<form action="../actions/action_editprofile.php" method="post" class="edit-profile-form">
  <label for="Uname">Username:</label>
  <input type="text" id="Uname" name="Uname" value="<?php echo htmlspecialchars($user->username); ?>" required>

  <label for="Email">Email:</label>
  <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user->email); ?>" required>

  <label for="Password1">New Password:</label>
  <input type="password" id="Password1" name="Password1">

  <label for="Password2">Confirm New Password:</label>
  <input type="password" id="Password2" name="Password2">

  <input type="submit" value="Update Profile">
</form>

<?php drawFooter(); ?>






