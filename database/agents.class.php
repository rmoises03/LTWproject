<?php
  declare(strict_types = 1);

  class Agent {
    public int $agentId;
    public int $departmentId;

    public function __construct(int $agentId, int $departmentId)
    {
      $this->agentId = $agentId;
      $this->departmentId = $departmentId;
    }

    function save(PDO $db) {
      $stmt = $db->prepare('
        INSERT INTO Agents (agent_id, department_id) 
        VALUES (?, ?)
        ON CONFLICT (agent_id, department_id) 
        DO NOTHING
      ');

      $stmt->execute(array($this->agentId, $this->departmentId));
    }

    static function getAgent(PDO $db, int $agentId, int $departmentId) : ?Agent {
      $stmt = $db->prepare('
        SELECT agent_id, department_id
        FROM Agents 
        WHERE agent_id = ? AND department_id = ?
      ');

      $stmt->execute(array($agentId, $departmentId));
  
      if ($agent = $stmt->fetch()) {
        return new Agent(
          $agent['agent_id'],
          $agent['department_id']
        );
      } else return null;
    }
  }
?>
