<?php $title='Registration'; require 'views/partials/header.php'; ?>
<div class="auth-box register-box">
<h2>Create Account</h2>
<p class="muted">Choose your account type. Admin accounts are created separately by the system.</p>
<form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Name<input name="name" placeholder="Full name" required></label>
<label>Email<input type="email" name="email" placeholder="you@example.com" required></label>
<label>Password<input type="password" name="password" minlength="6" placeholder="Minimum 6 characters" required></label>

<div class="role-section">
<h3>Register As</h3>
<div class="role-options">
<label class="role-card">
<input type="radio" name="role" value="general_user" checked>
<span><strong>General User</strong><small>Browse events, book seats, pay and request refunds.</small></span>
</label>
<label class="role-card">
<input type="radio" name="role" value="event_manager">
<span><strong>Event Manager</strong><small>Manage transportation, notifications and booking performance.</small></span>
</label>
<label class="role-card">
<input type="radio" name="role" value="volunteer">
<span><strong>Volunteer</strong><small>Handle logistics, refund assistance and customer inquiries.</small></span>
</label>
</div>
</div>

<button class="btn" type="submit">Create Account</button>
</form>
<p>Already registered? <a href="<?=esc(app_url('page=login'))?>">Login</a></p>
</div>
<?php require 'views/partials/footer.php'; ?>
