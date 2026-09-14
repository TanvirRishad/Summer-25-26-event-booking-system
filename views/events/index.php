<?php $title='Events'; require 'views/partials/header.php'; ?>
<h1>Events</h1>
<form class="filter" method="get">
<input type="hidden" name="page" value="events">
<input name="search" placeholder="Search event or location" value="<?=esc($_GET['search']??'')?>">
<input name="category" placeholder="Category" value="<?=esc($_GET['category']??'')?>">
<input type="date" name="date" value="<?=esc($_GET['date']??'')?>">
<button class="btn">Filter</button>
</form>
<div class="grid cards">
<?php foreach($events as $event): ?>
<div class="card">
<span class="badge"><?=esc($event['category'])?></span>
<h3><?=esc($event['title'])?></h3>
<p><?=esc($event['description'])?></p>
<p><?=esc($event['location'])?></p>
<p><?=date('d M Y, h:i A',strtotime($event['event_date']))?></p>
<p><b><?=esc($event['available_seats'])?></b> seats available</p>
<a class="btn" href="<?=esc(app_url('page=event_details&id='.$event['id']))?>">Details</a>
</div>
<?php endforeach; ?>
</div>
<?php require 'views/partials/footer.php'; ?>
