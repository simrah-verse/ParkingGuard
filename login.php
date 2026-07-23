<?php
require_once __DIR__ . '/includes/functions.php';

if (is_logged_in()) {
    redirect('/index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        redirect('/index.php');
    }
    $error = 'Invalid email or password.';
}
$pageTitle = 'Login';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Secure login for ParkingGuard visitor vehicle and parking control system.">
    <title>Login | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
<main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card p-4 p-md-5" style="max-width: 460px; width: 100%;">
        <div class="text-center mb-4">
            <i class="fa-solid fa-square-parking text-primary display-4"></i>
            <h1 class="h3 mt-3 mb-1"><?= APP_NAME ?></h1>
            <p class="text-muted mb-0"><?= APP_TAGLINE ?></p>
        </div>
        <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
        <form method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="mb-3">
                <label class="form-label" for="email">Email address</label>
                <input class="form-control" id="email" name="email" type="email" value="admin@parkingguard.local" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" id="password" name="password" type="password" value="admin123" required>
            </div>
            <button class="btn btn-primary w-100" type="submit">Sign in</button>
        </form>
    </div>
</main>
</body>
</html>
