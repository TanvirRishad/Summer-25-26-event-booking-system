<?php $title='Login'; require 'views/partials/header.php'; ?>
<div class="auth-box">
<h2>Welcome Back</h2>
<form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Email / Admin Login ID<input name="login" placeholder="Email or Admin ID" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn">Login</button>
</form>
<div class="card code-box"><strong>Admin Login</strong><br>Login ID: <code>ADMIN-2027-001</code><br>Password: <code>Admin@2027</code></div>
<p>Don't have an account? <a href="<?=esc(app_url('page=register'))?>">Register</a></p>
</div>
<?php require 'views/partials/footer.php'; ?>
