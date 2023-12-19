<?php
declare(strict_types = 1);
//criar a página na qual se criam os tickets
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/db_connection.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/index.php');
    exit;
}

$db = getDatabaseConnection();

$departments = Department::getAllDepartments($db);

require_once(__DIR__ . '/../templates/common.tpl.php'); 
drawHeader($session);
?>

<h2>Create Ticket</h2>

<form action="../actions/submit_ticket.php" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="ticket_title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="ticket_description" required></textarea>

    <label for="department">Department:</label>
    <select id="department" name="ticket_department">
        <?php
        $departmentOptions = Department::getDepartmentOptions($db); 
        echo $departmentOptions; 
        ?>
    </select>

    <button type="submit">Submit</button>
</form>

<?php 
drawFooter(); 
?>


