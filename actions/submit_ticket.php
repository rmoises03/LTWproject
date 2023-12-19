<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/db_connection.db.php');
require_once(__DIR__ . '/../database/tickets.class.php');
require_once(__DIR__ . '/../database/department.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: /');
    exit;
}

$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit("POST request expected");
}

$ticket_title = $_POST['ticket_title'];
$ticket_description = $_POST['ticket_description'];

if (!empty($_POST['ticket_department'])){
    $ticket_department = $_POST['ticket_department'];
    $departmentID = Department::getDepartment($db, $ticket_department);
}
else{
    $departmentID = null;
}

$ticketID = Ticket::createTicket($db, $ticket_title, $ticket_description, $departmentID->id, $session->getId(), "open", "low");

if ($_FILES['files']['error'][0] != 4){
}

header("Location: /../pages/tickets.php");

//submteter tickets
?>

