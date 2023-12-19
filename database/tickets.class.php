<?php
declare(strict_types=1);

class Ticket {
    public int $id;
    public string $title;
    public string $description;
    public ?string $status;
    public ?string $priority;
    public int $submitterId;
    public ?int $assigneeId;
    public int $departmentId;
    public DateTime $creationDate;
    public DateTime $updateDate;

    public function __construct(int $id, string $title, string $description, ?string $status, ?string $priority, int $submitterId, ?int $assigneeId, int $departmentId, DateTime $creationDate, DateTime $updateDate)
    {
      $this->id = $id;
      $this->title = $title;
      $this->description = $description;
      $this->status = $status;
      $this->priority = $priority;
      $this->submitterId = $submitterId;
      $this->assigneeId = $assigneeId;
      $this->departmentId = $departmentId;
      $this->creationDate = $creationDate;
      $this->updateDate = $updateDate;
    }

    public static function createTicket(PDO $db, string $title, string $description, int $department_id, int $submitter_id, string $status = "open", string $priority = "low"): int {
      $stmt = $db->prepare('INSERT INTO tickets (title, description, status, priority, submitter_id, department_id, creation_date, update_date) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
      $stmt->execute([$title, $description, $status, $priority, $submitter_id, $department_id]);
      return (int)$db->lastInsertId();
  }
  
    public static function getTicket(PDO $db, int $id): Ticket {
      $stmt = $db->prepare('SELECT ticket_id, title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date FROM Tickets WHERE ticket_id = ?');
      $stmt->execute([$id]);
      $ticket = $stmt->fetch();
      return new Ticket(
        $ticket['ticket_id'],
        $ticket['title'],
        $ticket['description'],
        $ticket['status'],
        $ticket['priority'],
        $ticket['submitter_id'],
        $ticket['assignee_id'] ?? null,
        $ticket['department_id'],
        new DateTime($ticket['creation_date']),
        new DateTime($ticket['update_date'])
      );
    }

    public static function getTicketsByStatus(PDO $db, string $status): array {
      $stmt = $db->prepare('SELECT ticket_id, title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date FROM Tickets WHERE lower(status) = ?');
      $stmt->execute([strtolower($status)]);
      $tickets = $stmt->fetchAll();
      $ticketArray = array();
      foreach ($tickets as $ticket) {
        $ticketArray[] = new Ticket(
          $ticket['ticket_id'],
          $ticket['title'],
          $ticket['description'],
          $ticket['status'],
          $ticket['priority'],
          $ticket['submitter_id'],
          $ticket['assignee_id'] ?? null,
          $ticket['department_id'],
          new DateTime($ticket['creation_date']),
          new DateTime($ticket['update_date'])
        );
      }
      return $ticketArray;
    }


    public static function getTicketsBySubmitterId(PDO $db, int $submitterId): array {
      $stmt = $db->prepare('SELECT ticket_id, title, description, status, priority, submitter_id, assignee_id, department_id, creation_date, update_date FROM Tickets WHERE submitter_id = ?');
      $stmt->execute([$submitterId]);
      $tickets = $stmt->fetchAll();
      $ticketArray = array();
      foreach ($tickets as $ticket) {
        $ticketArray[] = new Ticket(
          $ticket['ticket_id'],
          $ticket['title'],
          $ticket['description'],
          $ticket['status'],
          $ticket['priority'],
          $ticket['submitter_id'],
          $ticket['assignee_id'] ?? null,
          $ticket['department_id'],
          new DateTime($ticket['creation_date']),
          new DateTime($ticket['update_date'])
        );
      }
      return $ticketArray;
    }


    public function save(PDO $db): void {
      $stmt = $db->prepare('UPDATE Tickets SET title = ?, description = ?, status = ?, priority = ?, submitter_id = ?, assignee_id = ?, department_id = ?, update_date = CURRENT_TIMESTAMP WHERE ticket_id = ?');
      $stmt->execute([$this->title, $this->description, $this->status, $this->priority, $this->submitterId, $this->assigneeId, $this->departmentId, $this->id]);
    }
  
}



?>

