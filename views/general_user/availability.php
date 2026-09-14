<?php $title='Availability'; require 'views/partials/header.php'; ?>
<h1>Event Availability Filter</h1>
<form class="filter" method="get">
<input type="hidden" name="page" value="availability">
<input name="search" placeholder="Search" value="<?=esc($_GET['search']??'')?>">
<input name="category" placeholder="Category" value="<?=esc($_GET['category']??'')?>">
<input type="date" name="date" value="<?=esc($_GET['date']??'')?>">
<button class="btn">Filter</button>
</form>
<div class="grid cards"><?php foreach($events as $event): ?><div class="card">
<h3><?=esc($event['title'])?></h3><p><?=esc($event['location'])?></p>
<p><b><?=esc($event['available_seats'])?></b> available</p>
<a class="btn" href="<?=esc(app_url('page=booking&event_id='.$event['id']))?>">Book Seat</a>
</div><?php endforeach; ?></div>
<?php require 'views/partials/footer.php'; ?>
