<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? APP_NAME) ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?=esc(app_url())?>">Event<span>Book</span></a>
    <nav>
        <a href="<?=esc(app_url())?>">Home</a>
        <a href="<?=esc(app_url('page=events'))?>">Events</a>
        <?php if(is_logged_in()): ?>
            <a href="<?=esc(app_url('page='.role_dashboard($_SESSION['role'])))?>">Dashboard</a>
            <a href="<?=esc(app_url('page=logout'))?>">Logout</a>
        <?php else: ?>
            <a href="<?=esc(app_url('page=login'))?>">Login</a>
            <a class="btn small" href="<?=esc(app_url('page=register'))?>">Register</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
<?php if($msg=get_flash('success')): ?><div class="alert success"><?=esc($msg)?></div><?php endif; ?>
<?php if($msg=get_flash('error')): ?><div class="alert error"><?=esc($msg)?></div><?php endif; ?>
