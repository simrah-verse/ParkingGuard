<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        redirect('/login.php');
    }
}

function current_user_name(): string
{
    return $_SESSION['user_name'] ?? 'Guest';
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function consume_flash(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }
    }
}

function auto_allocate_slot(string $vehicleType): ?array
{
    $stmt = db()->prepare("SELECT * FROM parking_slots WHERE status = 'Available' AND slot_type = ? ORDER BY slot_code ASC LIMIT 1");
    $stmt->execute([$vehicleType]);
    $slot = $stmt->fetch();

    if (!$slot) {
        $stmt = db()->query("SELECT * FROM parking_slots WHERE status = 'Available' ORDER BY slot_code ASC LIMIT 1");
        $slot = $stmt->fetch() ?: null;
    }

    return $slot ?: null;
}

function calculate_fee(string $checkIn, ?string $checkOut = null): float
{
    $start = new DateTime($checkIn);
    $end = new DateTime($checkOut ?: date('Y-m-d H:i:s'));
    $seconds = max(0, $end->getTimestamp() - $start->getTimestamp());
    $hours = max(1, (int) ceil($seconds / 3600));
    return round($hours * HOURLY_RATE, 2);
}

function dashboard_counts(): array
{
    return [
        'visitors' => (int) db()->query('SELECT COUNT(*) FROM visitors')->fetchColumn(),
        'vehicles' => (int) db()->query('SELECT COUNT(*) FROM vehicles')->fetchColumn(),
        'available_slots' => (int) db()->query("SELECT COUNT(*) FROM parking_slots WHERE status = 'Available'")->fetchColumn(),
        'active_records' => (int) db()->query("SELECT COUNT(*) FROM parking_records WHERE status = 'Active'")->fetchColumn(),
    ];
}
