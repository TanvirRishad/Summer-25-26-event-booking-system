<?php $title='Home'; require 'views/partials/header.php'; ?>
<section class="hero">
    <div>
        <p class="eyebrow">SMART EVENT BOOKING</p>
        <h1>Discover. Book. Experience.</h1>
        <p>Find events, choose your seat, apply promotions and manage your bookings in one place.</p>
        <a class="btn" href="<?=esc(app_url('page=events'))?>">Explore Events</a>
    </div>
</section>
<h2>Upcoming Events</h2>
<div class="grid cards">
<?php foreach($events as $event): ?>
<div class="card">
    <span class="badge"><?=esc($event['category'])?></span>
    <h3><?=esc($event['title'])?></h3>
    <p><?=esc($event['location'])?></p>
    <p><?=date('d M Y, h:i A',strtotime($event['event_date']))?></p>
    <strong>৳<?=number_format($event['price'],2)?></strong>
    <a class="btn outline" href="<?=esc(app_url('page=event_details&id='.$event['id']))?>">View Event</a>
</div>
<?php endforeach; ?>
</div>
<?php require 'views/partials/footer.php'; ?>
