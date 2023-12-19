<?php
    declare(strict_types = 1);
//criar a página das "faq"
    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/db_connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../templates/faq.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');


    if (!$session->isLoggedIn())
        die(header('Location: /pages/login.php'));
    drawHeader($session);
    $faqs = FAQ::fetchFAQs($db, 10, 0);
    drawFAQList($faqs);


    drawFooter();
?>