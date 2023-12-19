<?php
  declare(strict_types = 1);
//criar a página onde se editam os tickets
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/db_connection.db.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../database/tickets.class.php');
  require_once(__DIR__ . '/../database/department.class.php');

  $session = new Session();

  if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
  }

  $db = getDatabaseConnection();
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $departmentId = (int)$_POST['department'];

    $ticket = Ticket::getTicket($db, $id);
    $ticket->title = $title;
    $ticket->description = $description;
    $ticket->priority = $priority;
    $ticket->departmentId = $departmentId;
    $ticket->save($db);

    header('Location: tickets.php');
    exit;
  } else {
    $ticketId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if ($ticketId === null) {
      echo 'Invalid ticket id';
      exit;
    }

    $ticket = Ticket::getTicket($db, (int)$_GET['id']);

    if ($ticket === null) {
      echo 'No ticket found with the given id';
      exit;
    }

    if ($ticket->submitterId !== $session->getId()) {
      echo 'You do not have permission to edit this ticket';
      exit;
    }
  }
?>

<?php drawHeader($session); ?>

<h2>Edit Ticket</h2>

<form method="post" action="">
  <label for="title">Title</label><br>
  <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($ticket->title); ?>" required><br>

  <label for="description">Description</label><br>
  <textarea id="description" name="description" required><?php echo htmlspecialchars($ticket->description); ?></textarea><br>

  <label for="priority">Priority</label><br>
  <select id="priority" name="priority" required>
    <option value="low" <?php if($ticket->priority == 'low') echo 'selected'; ?>>Low</option>
    <option value="medium" <?php if($ticket->priority == 'medium') echo 'selected'; ?>>Medium</option>
    <option value="high" <?php if($ticket->priority == 'high') echo 'selected'; ?>>High</option>
  </select><br>

  <label for="department">Department</label><br>
  <select id="department" name="department" required>
    <?php
    $departments = Department::getAllDepartments($db);
    foreach ($departments as $department) {
      echo '<option value="' . $department->id . '"';
      if ($ticket->departmentId == $department->id) echo ' selected';
      echo '>' . htmlspecialchars($department->name) . '</option>';
    }
    ?>
  </select><br>

  <input type="hidden" name="id" value="<?php echo $ticket->id; ?>">
  <input type="submit" value="Submit">
</form>


<?php drawFooter(); ?>

<script src="script.js"></script>

