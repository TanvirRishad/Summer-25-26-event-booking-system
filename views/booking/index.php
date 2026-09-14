<?php $title='Seat Booking'; require 'views/partials/header.php'; ?>
<div class="card">
<h2>Book: <?=esc($event['title'])?></h2>
<form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<input type="hidden" name="event_id" value="<?=$event['id']?>">
<label>Seat
<select name="seat_id" required>
<option value="">Select a seat</option>
<?php foreach($seats as $seat): ?><option value="<?=$seat['id']?>"><?=esc($seat['seat_number'])?></option><?php endforeach; ?>
</select></label>
<label>Promotional Code <input name="promo_code" placeholder="Optional"></label>
<p class="muted">Original price: ৳<?=number_format($event['price'],2)?></p>
<button class="btn">Continue to Payment</button>
</form>
</div>
<?php require 'views/partials/footer.php'; ?>
