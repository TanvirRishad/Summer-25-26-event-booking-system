<?php $title='Live Notifications'; require 'views/partials/header.php'; ?>
<h1>Live Notifications</h1><div class="card"><form method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Event<select name="event_id"><?php foreach($events as $e): ?><option value="<?=$e['id']?>"><?=esc($e['title'])?></option><?php endforeach; ?></select></label>
<label>Message<textarea name="message" required></textarea></label><button class="btn">Send Notification</button></form></div>
<table><tr><th>Event</th><th>Message</th><th>Created</th></tr><?php foreach($notifications as $n): ?><tr><td><?=esc($n['title'])?></td><td><?=esc($n['message'])?></td><td><?=esc($n['created_at'])?></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
