<?php $title='Profile'; require 'views/partials/header.php'; ?>
<div class="card"><h2>Profile</h2><form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Name<input name="name" value="<?=esc($user['name'])?>" required></label>
<label>Email<input value="<?=esc($user['email'])?>" disabled></label>
<label>Phone<input name="phone" value="<?=esc($user['phone'])?>"></label>
<label>Address<textarea name="address"><?=esc($user['address'])?></textarea></label>
<button class="btn">Update Profile</button>
</form></div>
<?php require 'views/partials/footer.php'; ?>
