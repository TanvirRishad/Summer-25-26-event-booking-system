<?php $title='Refund Assistance'; require 'views/partials/header.php'; ?>
<h1>Refund Assistance</h1><table><tr><th>User</th><th>Booking</th><th>Event</th><th>Reason</th><th>Status</th><th>Action</th></tr>
<?php foreach($refunds as $r): ?><tr><td><?=esc($r['user_name'])?></td><td><?=esc($r['booking_code'])?></td><td><?=esc($r['title'])?></td><td><?=esc($r['reason'])?></td><td><?=esc($r['status'])?></td><td>
<form class="inline" method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>"><input type="hidden" name="id" value="<?=$r['id']?>"><select name="status"><option>under_review</option><option>approved</option><option>rejected</option></select><button class="btn small">Update</button></form></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
