<?php $title='My Bookings'; require 'views/partials/header.php'; ?>
<h1>My Bookings</h1>
<table><tr><th>Code</th><th>Event</th><th>Date</th><th>Amount</th><th>Status</th><th>Action</th></tr>
<?php foreach($bookings as $b): ?><tr>
<td><?=esc($b['booking_code'])?></td><td><?=esc($b['title'])?></td><td><?=esc($b['event_date'])?></td>
<td>৳<?=number_format($b['total_amount'],2)?></td><td><span class="badge"><?=esc($b['status'])?></span></td>
<td><?php if($b['status']==='pending'): ?><a href="<?=esc(app_url('page=payment&id='.$b['id']))?>">Pay</a><?php elseif($b['status']==='confirmed'): ?>
<form class="inline" method="post" action="<?=esc(app_url('page=cancel_booking&id='.$b['id']))?>"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>"><button class="link danger">Cancel</button></form><?php endif; ?></td>
</tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
