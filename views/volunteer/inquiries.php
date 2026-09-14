<?php $title='Customer Inquiries'; require 'views/partials/header.php'; ?>
<h1>Customer Inquiry Handling</h1><table><tr><th>User</th><th>Event</th><th>Question</th><th>Status</th><th>Answer</th></tr>
<?php foreach($inquiries as $i): ?><tr><td><?=esc($i['user_name'])?></td><td><?=esc($i['title'])?></td><td><?=esc($i['question'])?></td><td><?=esc($i['status'])?></td><td>
<form method="post"><input type="hidden" name="csrf_token" value="<?=csrf_token()?>"><input type="hidden" name="id" value="<?=$i['id']?>"><textarea name="answer" required><?=esc($i['answer'])?></textarea><button class="btn small">Answer</button></form></td></tr><?php endforeach; ?></table>
<?php require 'views/partials/footer.php'; ?>
