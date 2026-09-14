<?php $title='Transportation'; require 'views/partials/header.php'; ?>
<h1>Transportation</h1><div class="card"><form method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>">
<label>Event<select name="event_id" required><?php foreach($events as $e): ?><option value="<?=$e['id']?>"><?=esc($e['title'])?></option><?php endforeach; ?></select></label>
<label>Type<input name="type" placeholder="Bus / Shuttle" required></label><label>Provider<input name="provider" required></label>
<label>Departure<input name="departure" required></label><label>Arrival<input name="arrival" required></label><button class="btn">Add Transportation</button></form></div>
<table><tr><th>Event</th><th>Type</th><th>Provider</th><th>Departure</th><th>Arrival</th></tr>
<?php foreach($transport as $t): ?><tr><td><?=esc($t['title'])?></td><td><?=esc($t['type'])?></td><td><?=esc($t['provider'])?></td><td><?=esc($t['departure'])?></td><td><?=esc($t['arrival'])?></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
