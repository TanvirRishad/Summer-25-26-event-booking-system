<?php
$title = 'Feedback Action';
require 'views/partials/header.php';
?>

<h1>Feedback Action</h1>

<table>
    <tr>
        <th>User</th>
        <th>Event</th>
        <th>Feedback</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach ($feedback as $f): ?>
        <tr>
            <td>
                <?= esc($f['user_name']) ?>
            </td>

            <td>
                <?= esc($f['title']) ?>
            </td>

            <td>
                <?= esc($f['message']) ?>
            </td>

            <td>
                <?= esc($f['status']) ?>
            </td>

            <td>
                <form class="inline" method="post">

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= csrf_token() ?>"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $f['id'] ?>"
                    >

                    <select name="status">
                        <option>reviewed</option>
                        <option>resolved</option>
                        <option>rejected</option>
                    </select>

                    <button class="btn small">
                        Update
                    </button>

                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php
require 'views/partials/footer.php';
?>