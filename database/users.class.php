<?php
  declare(strict_types = 1);

  class User {
    public int $id;
    public string $username;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $role;

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName, string $email, string $role)
    {
      $this->id = $id;
      $this->username = $username;
      $this->password = $password;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->role = $role;
    
    }

    function name() {
      return $this->firstName . ' ' . $this->lastName;
    }

    function save(PDO $db) {
      $stmt = $db->prepare('
        UPDATE users SET username = ?, password = ?, first_name = ?, last_name = ?, email = ?, role = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->username, sha1($this->password), $this->firstName, $this->lastName, $this->email, $this->role, $this->id));
    }

    static function getUserWithCredentials(PDO $db, string $username, string $password) : ?User {
      $stmt = $db->prepare('
        SELECT user_id, username, password, first_name, last_name, email, role
        FROM users 
        WHERE username = ?
      ');
    
      $stmt->execute(array($username));
    
      if ($user = $stmt->fetch()) {
        if (password_verify($password, $user['password'])) {
          return new User(
            $user['user_id'],
            $user['username'],
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['email'],
            $user['role']
          );
        }
      } 
      return null;
    }

    static function registerUser(PDO $db, string $username, string $password, string $firstName, string $lastName, string $email) : ?User {
      $stmt = $db->prepare('
          SELECT username
          FROM users 
          WHERE username = ?
      ');
      $stmt->execute(array($username));
      
      if ($stmt->fetch()) {

          return null;
      }
      
      $stmt = $db->prepare('SELECT email FROM users WHERE email = ?');
      $stmt->execute(array($email));

      if ($stmt->fetch()) {
        return null;
      }


      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      
      $stmt = $db->prepare('
          INSERT INTO users (username, password, first_name, last_name, email, role)
          VALUES (?, ?, ?, ?, ?, ?)
      ');
      $role = 'user';
      
      $stmt->execute(array($username, $hashedPassword, $firstName, $lastName, $email, $role));
      
    
      $stmt = $db->prepare('SELECT user_id FROM users WHERE username = ?');
      $stmt->execute(array($username));
      $userIdRow = $stmt->fetch();
      $userId = (int)$userIdRow['user_id'];
      
      return new User($userId, $username, $hashedPassword, $firstName, $lastName, $email, $role);
  }
  

    static function getUser(PDO $db, int $id) : User {
      $stmt = $db->prepare('
        SELECT user_id, username, password, first_name, last_name, email, role
        FROM users 
        WHERE user_id = ?
      ');

      $stmt->execute(array($id));
      $user = $stmt->fetch();
      
      return new User(
        $user['user_id'],
        $user['username'],
        $user['password'],
        $user['first_name'],
        $user['last_name'],
        $user['email'],
        $user['role']
      );
    }

  }
?>

