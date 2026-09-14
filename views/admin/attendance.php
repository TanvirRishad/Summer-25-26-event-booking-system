<?php $title='Attendance'; require 'views/partials/header.php'; ?>
<h1>Attendance Monitoring</h1><table><tr><th>Booking</th><th>User</th><th>Event</th><th>Status</th><th>Update</th></tr>
<?php foreach($attendance as $a): ?><tr><td><?=esc($a['booking_code'])?></td><td><?=esc($a['user_name'])?></td><td><?=esc($a['title'])?></td><td><?=esc($a['status'])?></td><td>
<form class="inline" method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>"><input type="hidden" name="booking_id" value="<?=$a['booking_id']?>"><select name="status"><option>present</option><option>absent</option></select><button class="btn small">Save</button></form></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
