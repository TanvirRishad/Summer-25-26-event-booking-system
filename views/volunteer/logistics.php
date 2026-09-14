<?php $title='Event Logistics'; require 'views/partials/header.php'; ?>
<h1>Event Logistics</h1><table><tr><th>Event</th><th>Task</th><th>Assigned</th><th>Status</th><th>Update</th></tr>
<?php foreach($logistics as $l): ?><tr><td><?=esc($l['title'])?></td><td><?=esc($l['task'])?></td><td><?=esc($l['assigned_to'])?></td><td><?=esc($l['status'])?></td><td>
<form class="inline" method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>"><input type="hidden" name="id" value="<?=$l['id']?>"><select name="status"><option>pending</option><option>in_progress</option><option>completed</option></select><button class="btn small">Save</button></form></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
