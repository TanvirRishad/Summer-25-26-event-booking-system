<?php $title='Payment'; require 'views/partials/header.php'; ?>
<div class="auth-box">
<h2>Payment</h2>
<p>Booking: <b><?=esc($booking['booking_code'])?></b></p>
<p>Total: <strong>৳<?=number_format($booking['total_amount'],2)?></strong></p>
<form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Payment Method
<select name="method"><option value="card">Card</option><option value="mobile_banking">Mobile Banking</option><option value="bank">Bank</option></select>
</label>
<label>Card / Account Reference<input name="reference" placeholder="Demo payment UI" required></label>
<button class="btn">Pay & Confirm</button>
</form>
<p class="muted">This is a demonstration payment interface; no real transaction is processed.</p>
</div>
<?php require 'views/partials/footer.php'; ?>
