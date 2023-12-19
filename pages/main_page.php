<?php 
  declare(strict_types = 1); 
//criar página principal
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
<?php
  if ($user->role == 'admin') {
    header('Location: ../pages/admin_page.php');
    exit;
  }
?>
<?php require_once(__DIR__ . '/../templates/common.tpl.php'); ?>

<?php drawHeader($session); ?>

<h2>Welcome, <?php echo htmlspecialchars($session->getName()); ?>!</h2>

<h3>Your Profile</h3>
<ul>
  <li>Username: <?php echo htmlspecialchars($user->username); ?></li>
  <li>Name: <?php echo htmlspecialchars($user->name()); ?></li>
  <li>Email: <?php echo htmlspecialchars($user->email); ?></li>
</ul>


<a href="../pages/create_ticket.php">
  <button type="button">Submit a new ticket</button>
</a>

<a href="../pages/tickets.php">
  <button type="button">View submitted tickets</button>
</a>

<a href="../pages/faq.php">
  <button type="button">FAQ</button>
</a>

<?php drawFooter(); ?>
