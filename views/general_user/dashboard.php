<?php $title='User Dashboard'; require 'views/partials/header.php'; ?>
<h1>Hello, <?=esc($user['name'])?></h1>
<div class="grid stats">
<div class="stat"><b><?=count($bookings)?></b><span>My Bookings</span></div>
<div class="stat"><b><?=count(array_filter($bookings,fn($b)=>$b['status']==='confirmed'))?></b><span>Confirmed</span></div>
</div>
<div class="dashboard-links">
<a href="<?=esc(app_url('page=my_bookings'))?>">My Bookings</a>
<a href="<?=esc(app_url('page=availability'))?>">Event Availability</a>
<a href="<?=esc(app_url('page=profile'))?>">Profile</a>
<a href="<?=esc(app_url('page=refunds'))?>">Refund Request</a>
</div>
<?php require 'views/partials/footer.php'; ?>
