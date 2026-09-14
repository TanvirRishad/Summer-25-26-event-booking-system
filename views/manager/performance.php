<?php 
$title = 'Booking Performance'; 
require 'views/partials/header.php'; 
?>

<h1>Booking Performance Monitoring</h1>

<table>
    <thead>
        <tr>
            <th>Event</th>
            <th>Date</th>
            <th>Bookings</th>
            <th>Revenue</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($performance as $p): ?>
            <tr>
                <td><?= esc($p['title']) ?></td>
                <td><?= esc($p['event_date']) ?></td>
                <td><?= esc($p['bookings']) ?></td>
                <td>৳<?= number_format($p['revenue'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'views/partials/footer.php'; ?>