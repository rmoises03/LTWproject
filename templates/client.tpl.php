<?php declare(strict_types = 1); ?>

<?php function drawProfileForm(User $user) { ?>
<h2>Profile</h2>
<form action="../actions/action_edit_profile.php" method="post" class="profile">

  <label for="name">Name:</label>
  <input id="name" type="text" name="name" value="<?=$user->name?>">
  
  <label for="email">Email:</label>
  <input id="email" type="text" name="email" value="<?=$user->email?>">  
  
  <button type="submit">Save</button>
</form>
<?php } ?>