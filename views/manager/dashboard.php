<?php $title='Event Manager Dashboard'; require 'views/partials/header.php'; ?>
<h1>Event Manager Dashboard</h1><div class="grid stats"><div class="stat"><b><?=count($mine)?></b><span>My Events</span></div><div class="stat"><b><?=array_sum(array_column($performance,'bookings'))?></b><span>Total Bookings</span></div></div>
<div class="dashboard-links"><a href="<?=esc(app_url('page=manager&action=transportation'))?>">Transportation</a><a href="<?=esc(app_url('page=manager&action=notifications'))?>">Live Notifications</a><a href="<?=esc(app_url('page=manager&action=performance'))?>">Booking Performance</a></div>
<?php require 'views/partials/footer.php'; ?>
