<?php $title='Administrator Dashboard'; require 'views/partials/header.php'; ?>
<h1>Administrator Dashboard</h1><div class="grid stats">
<div class="stat"><b><?=$stats['users']?></b><span>Users</span></div><div class="stat"><b><?=$stats['events']?></b><span>Events</span></div>
<div class="stat"><b><?=$stats['bookings']?></b><span>Bookings</span></div><div class="stat"><b>৳<?=number_format($stats['revenue'],2)?></b><span>Revenue</span></div>
</div>
<div class="dashboard-links"><a href="<?=esc(app_url('page=admin&action=feedback'))?>">Feedback Action</a><a href="<?=esc(app_url('page=admin&action=attendance'))?>">Attendance Monitoring</a><a href="<?=esc(app_url('page=admin&action=revenue'))?>">Revenue Monitoring</a></div>
<?php require 'views/partials/footer.php'; ?>
