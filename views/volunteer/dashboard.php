<?php $title='Volunteer Dashboard'; require 'views/partials/header.php'; ?>
<h1>Volunteer Dashboard</h1><div class="grid stats"><div class="stat"><b><?=count($logistics)?></b><span>Logistics Items</span></div><div class="stat"><b><?=count($refunds)?></b><span>Refund Requests</span></div><div class="stat"><b><?=count($inquiries)?></b><span>Customer Inquiries</span></div></div>
<div class="dashboard-links"><a href="<?=esc(app_url('page=volunteer&action=logistics'))?>">Event Logistics</a><a href="<?=esc(app_url('page=volunteer&action=refunds'))?>">Refund Assistance</a><a href="<?=esc(app_url('page=volunteer&action=inquiries'))?>">Customer Inquiries</a></div>
<?php require 'views/partials/footer.php'; ?>
