<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/db_connection.db.php');
    require_once(__DIR__ . '/../database/users.class.php');

    $db = getDatabaseConnection();

    $user = User::registerUser($db, $_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['email']);
    if($user){
        $session->setId($user->id);
        $session->setName($user->name());
        $session->addMessage('success', 'Registered successfully!');
        header('Location: ../pages/index.php');
        exit();
    } else{
        $session->addMessage('error', 'You already have an account!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    //criar o register
?>