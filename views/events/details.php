<?php $title='Event Details'; require 'views/partials/header.php'; ?>
<div class="detail card">
<span class="badge"><?=esc($event['category'])?></span>
<h1><?=esc($event['title'])?></h1>
<p><?=esc($event['description'])?></p>
<div class="info-grid">
<div><b>Date</b><br><?=date('d M Y, h:i A',strtotime($event['event_date']))?></div>
<div><b>Location</b><br><?=esc($event['location'])?></div>
<div><b>Price</b><br>৳<?=number_format($event['price'],2)?></div>
<div><b>Manager</b><br><?=esc($event['manager_name']??'Event Team')?></div>
</div>
<a class="btn" href="<?=esc(app_url('page=booking&event_id='.$event['id']))?>">Book a Seat</a>
</div>
<?php require 'views/partials/footer.php'; ?>
