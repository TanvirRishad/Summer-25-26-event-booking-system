<?php $title='Refund Request'; require 'views/partials/header.php'; ?>
<h1>Refund Request</h1>
<div class="card"><form method="post">
<input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Booking<select name="booking_id" required><?php foreach($bookings as $b): if(in_array($b['status'],['confirmed','cancelled'])): ?><option value="<?=$b['id']?>"><?=esc($b['booking_code'].' - '.$b['title'])?></option><?php endif; endforeach; ?></select></label>
<label>Reason<textarea name="reason" required></textarea></label><button class="btn">Submit Request</button>
</form></div>
<h2>My Requests</h2><table><tr><th>Booking</th><th>Event</th><th>Reason</th><th>Status</th></tr>
<?php foreach($refunds as $r): ?><tr><td><?=esc($r['booking_code'])?></td><td><?=esc($r['title'])?></td><td><?=esc($r['reason'])?></td><td><?=esc($r['status'])?></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
