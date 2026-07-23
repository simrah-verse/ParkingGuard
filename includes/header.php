<?php
$pageTitle = $pageTitle ?? APP_NAME;
$pageDescription = $pageDescription ?? 'Manage visitor vehicles, parking slots, check-ins, reports, and parking control operations.';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="robots" content="index, follow">
    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>
    <link rel="canonical" href="http://localhost<?= BASE_URL ?>/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php if (is_logged_in()): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top no-print">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php"><i class="fa-solid fa-square-parking me-2"></i><?= APP_NAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pages/visitors.php">Visitors</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pages/vehicles.php">Vehicles</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pages/slots.php">Slots</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pages/parking.php">Parking</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pages/reports.php">Reports</a></li>
            </ul>
            <div class="d-flex align-items-center text-white gap-3">
                <span><i class="fa-solid fa-user-shield me-1"></i><?= e(current_user_name()) ?></span>
                <a class="btn btn-outline-light btn-sm" href="<?= BASE_URL ?>/logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<main class="container-fluid py-4">
<?php foreach (consume_flash() as $message): ?>
    <div class="alert alert-<?= e($message['type']) ?> alert-dismissible fade show no-print" role="alert">
        <?= e($message['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endforeach; ?>
