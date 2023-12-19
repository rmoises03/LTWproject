<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once(__DIR__ . '/../database/db_connection.db.php');
    require_once(__DIR__ . '/../database/users.class.php');

    $db = getDatabaseConnection();

    $user = User::getUserWithCredentials($db, $_POST['username'], $_POST['password']);

    if ($user) {
        $session->setId($user->id);
        $session->setName($user->name());
        $session->addMessage('success', 'Login successful!');
        header('Location: ../pages/main_page.php');
    } else {
        $session->addMessage('error', 'Wrong password');
        header('Location: ../pages/index.php');
    }
    //criar o login
?>