<?php
  declare(strict_types = 1);

  class Hashtag {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
      $this->id = $id;
      $this->name = $name;
    }

    function save(PDO $db) {
      $stmt = $db->prepare('
        UPDATE Hashtags SET name = ?
        WHERE hashtag_id = ?
      ');

      $stmt->execute(array($this->name, $this->id));
    }

    static function getHashtag(PDO $db, int $id) : ?Hashtag {
      $stmt = $db->prepare('
        SELECT hashtag_id, name
        FROM Hashtags 
        WHERE hashtag_id = ?
      ');

      $stmt->execute(array($id));
  
      if ($hashtag = $stmt->fetch()) {
        return new Hashtag(
          $hashtag['hashtag_id'],
          $hashtag['name']
        );
      } else return null;
    }
  }
?>
