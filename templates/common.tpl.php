<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session) { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Ticket Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../javascript/script.js" defer></script>
  </head>
  <body>

    <header>
      <h1><a href="/">Ticket Manager</a></h1>
      <?php 
        if ($session->isLoggedIn()) drawLogoutForm($session);
        else drawLoginForm($session);
      ?>
    </header>
  
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>

    <footer>
      Trouble Tickets Manager &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

<?php function drawLoginForm() { ?>
  <form action="../actions/action_login.php" method="post" class="login input-box">
    <input type="text" name="username" placeholder="username" required>
    <input type="password" name="password" placeholder="password" required>
    <div class="button-container">
      <button type="submit" class="login-btn">Login</button>
      <a href="../pages/register.php" class="register-link">Register</a>
    </div>
  </form>
<?php } ?>


<?php function drawLogoutForm(Session $session) { ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <a href="../pages/profile.php"><?=$session->getName()?></a>
    <button type="submit" class="logout-button">Logout</button>
  </form>
<?php } ?>


<?php function drawRegisterForm() { ?>
  <h2>Register</h2>
<form action="../actions/action_register.php" method="post" class="login input-box">
  <label>First Name:</label>
  <input type="text" name="first_name" required>
  
  <label>Last Name:</label>
  <input type="text" name="last_name" required>
  
  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Username:</label>
  <input type="text" name="username" required>
  
  <label>Password:</label>
  <input type="password" name="password" required>
  
  <button type="submit">Register</button>
</form>

<?php } ?>

<?php function drawRegister(Session $session) { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Ticket Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../javascript/script.js" defer></script>
  </head>
  <body>

    <header>
      <h1><a href="/">Ticket Manager</a></h1>
      <?php 
        drawRegisterForm();
      ?>
    </header>
  
    <section id="messages">
      <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
          <?=$messsage['text']?>
        </article>
      <?php } ?>
    </section>

    <main>

<?php } ?>

