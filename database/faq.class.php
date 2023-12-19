<?php
  declare(strict_types = 1);

  class Faq {
    public int $id;
    public string $question;
    public string $answer;
    public int $departmentId;

    public function __construct(int $id, string $question, string $answer, int $departmentId)
    {
      $this->id = $id;
      $this->question = $question;
      $this->answer = $answer;
      $this->departmentId = $departmentId;
    }

    function save(PDO $db) {
      $stmt = $db->prepare('
        UPDATE Faq SET question = ?, answer = ?, department_id = ?
        WHERE faq_id = ?
      ');

      $stmt->execute(array($this->question, $this->answer, $this->departmentId, $this->id));
    }

    static function getFaq(PDO $db, int $id) : ?Faq {
      $stmt = $db->prepare('
        SELECT faq_id, question, answer, department_id
        FROM Faq 
        WHERE faq_id = ?
      ');

      $stmt->execute(array($id));

      if ($faq = $stmt->fetch()) {
        return new Faq(
          $faq['faq_id'],
          $faq['question'],
          $faq['answer'],
          $faq['department_id']
        );
      } else return null;
    }
    
    static function getFaqsByDepartment(PDO $db, int $departmentId) : array {
      $stmt = $db->prepare('
        SELECT faq_id, question, answer, department_id
        FROM Faq 
        WHERE department_id = ?
      ');

      $stmt->execute(array($departmentId));

      $faqs = $stmt->fetchAll();
      $faqArray = array();
      foreach ($faqs as $faq) {
        $faqArray[] = new Faq(
          $faq['faq_id'],
          $faq['question'],
          $faq['answer'],
          $faq['department_id']
        );
      }

      return $faqArray;
    }


    static function fetchFAQs(PDO $db, int $ammount, int $page) {
      $stmt = $db->prepare('
        SELECT faq_id, question, answer, department_id
        FROM faq
        ORDER BY 1
        LIMIT ? OFFSET ?
      ');

      $stmt->execute(array($ammount, $page * $ammount));
  
      $rawData = $stmt->fetchAll(PDO::FETCH_OBJ);

      $faqs = array();
      foreach ($rawData as $faq)
        array_push($faqs, new FAQ(
          $faq->faq_id,
          $faq->question,
          $faq->answer,
          $faq->department_id,
        ));

      return $faqs;
    }
  }
?>
