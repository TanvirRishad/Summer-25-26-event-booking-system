<?php
$title = 'Revenue Monitoring';
require 'views/partials/header.php';
?>

<h1>Revenue Monitoring</h1>

<div class="stat">
    <b>
        ৳<?= number_format($revenue, 2) ?>
    </b>
    <span>
        Total Paid Revenue
    </span>
</div>

<table>
    <tr>
        <th>Payment</th>
        <th>Booking</th>
        <th>Event</th>
        <th>User</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>

    <?php foreach ($payments as $p): ?>
        <tr>
            <td>
                <?= $p['id'] ?>
            </td>

            <td>
                <?= esc($p['booking_code']) ?>
            </td>

            <td>
                <?= esc($p['title']) ?>
            </td>

            <td>
                <?= esc($p['user_name']) ?>
            </td>

            <td>
                ৳<?= number_format($p['amount'], 2) ?>
            </td>

            <td>
                <?= esc($p['status']) ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php
require 'views/partials/footer.php';
?>