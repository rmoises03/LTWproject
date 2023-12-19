<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit;
  }

  require_once(__DIR__ . '/../database/db_connection.db.php');
  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../database/tickets.class.php');
  require_once(__DIR__ . '/../database/department.class.php');
?>

<?php drawHeader($session); ?>

<h2>Your Tickets</h2>

<?php
  $tickets = Ticket::getTicketsBySubmitterId($db, $session->getId());
  
  if (empty($tickets)) {
    echo "<p>You have not submitted any tickets.</p>";
  } else {
    echo "<table>";
    echo "<tr><th>Ticket ID</th><th>Title</th><th>Status</th><th>Priority</th><th>Department</th><th>Edit</th></tr>";
    foreach ($tickets as $ticket) {
      $department = Department::getDepartmentId($db, $ticket->departmentId);
      echo "<tr>";
      echo "<td>{$ticket->id}</td>";
      echo "<td>{$ticket->title}</td>";
      echo "<td>{$ticket->status}</td>";
      echo "<td>{$ticket->priority}</td>";
      echo "<td>{$department->name}</td>";
      echo "<td><button onclick=\"location.href='../pages/edit_ticket.php?id={$ticket->id}'\">Edit</button></td>";
      echo "</tr>";
    }
    echo "</table>";
  }
?>

<?php drawFooter(); ?>
