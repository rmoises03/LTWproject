<?php
declare(strict_types=1);

class Department {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
      $this->id = $id;
      $this->name = $name;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public static function createDepartment(PDO $db, string $name): int {
        $stmt = $db->prepare('INSERT INTO departments (name) VALUES (?)');
        $stmt->execute([$name]);
        return $db->lastInsertId();
    }

    public function save(PDO $db): void {
        $stmt = $db->prepare('UPDATE departments SET name = ? WHERE department_id = ?');
        $stmt->execute([$this->name, $this->id]);
    }

    
    public static function getDepartment(PDO $db, string $name): Department {
        $stmt = $db->prepare('SELECT department_id, name FROM departments WHERE name = ?');
        $stmt->execute([$name]);
        $department = $stmt->fetch();
        return new Department($department['department_id'], $department['name']);
    }

    public static function getDepartmentId(PDO $db, int $id): ?Department {
        $stmt = $db->prepare('SELECT department_id, name FROM departments WHERE department_id = ?');
        $stmt->execute([$id]);
        $department = $stmt->fetch();
    
        if ($department) {
            return new Department($department['department_id'], $department['name']);
        } else {
            return null;
        }
    }
    

    public static function getAllDepartments(PDO $db): array {
        $stmt = $db->prepare('SELECT department_id, name FROM departments');
        $stmt->execute();
        $departments = $stmt->fetchAll();
        $departmentArray = array();
        foreach ($departments as $department) {
            $departmentArray[] = new Department($department['department_id'], $department['name']);
        }
        return $departmentArray;
    }

    static function getDepartmentOptions(PDO $db) {
        $stmt = $db->prepare('SELECT name FROM departments');
        $stmt->execute();
        $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        $options = '';
        foreach ($departments as $department) {
            $options .= "<option value=\"$department\">$department</option>";
        }
    
        return $options;
    }
}
?>


