<?php
  declare(strict_types = 1);

  class TicketHashtag {
    public int $ticketId;
    public int $hashtagId;

    public function __construct(int $ticketId, int $hashtagId)
    {
      $this->ticketId = $ticketId;
      $this->hashtagId = $hashtagId;
    }

    function save(PDO $db) {
      $stmt = $db->prepare('
        INSERT INTO Ticket_hashtag (ticket_id, hashtag_id) 
        VALUES (?, ?)
        ON CONFLICT (ticket_id, hashtag_id) 
        DO NOTHING
      ');

      $stmt->execute(array($this->ticketId, $this->hashtagId));
    }

    static function getTicketHashtags(PDO $db, int $ticketId) : array {
      $stmt = $db->prepare('
        SELECT ticket_id, hashtag_id
        FROM Ticket_hashtag 
        WHERE ticket_id = ?
      ');

      $stmt->execute(array($ticketId));

      $ticketHashtags = $stmt->fetchAll();
      $ticketHashtagArray = array();
      foreach ($ticketHashtags as $ticketHashtag) {
        $ticketHashtagArray[] = new TicketHashtag(
          $ticketHashtag['ticket_id'],
          $ticketHashtag['hashtag_id']
        );
      }

      return $ticketHashtagArray;
    }
  }
?>
