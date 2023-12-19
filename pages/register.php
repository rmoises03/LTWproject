<?php
//criar a página onde se regista
  declare(strict_types=1);

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../templates/common.tpl.php');

  $session = new Session();
  drawRegister($session);
  drawFooter();
?>
