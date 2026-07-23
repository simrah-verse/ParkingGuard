<?php
require_once __DIR__ . '/includes/functions.php';
require_login();
$pageTitle = 'Dashboard';
$counts = dashboard_counts();
$slotStats = [];
foreach (db()->query('SELECT status, COUNT(*) total FROM parking_slots GROUP BY status') as $row) {
    $slotStats[$row['status']] = (int) $row['total'];
}
$recent = db()->query("SELECT pr.*, v.plate_number, ps.slot_code, vi.full_name FROM parking_records pr JOIN vehicles v ON v.id=pr.vehicle_id JOIN parking_slots ps ON ps.id=pr.slot_id JOIN visitors vi ON vi.id=pr.visitor_id ORDER BY pr.check_in DESC LIMIT 8")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div>
        <h1 class="h2 mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Real-time overview of visitor parking operations.</p>
    </div>
    <a class="btn btn-primary mt-3 mt-md-0" href="<?= BASE_URL ?>/pages/parking.php"><i class="fa-solid fa-plus me-1"></i> New Check-in</a>
</div>
<div class="row g-3 mb-4">
    <?php foreach ([['Visitors','visitors','fa-users','primary'],['Vehicles','vehicles','fa-car','info'],['Available Slots','available_slots','fa-square-parking','success'],['Active Parking','active_records','fa-clock','danger']] as $card): ?>
    <div class="col-sm-6 col-xl-3"><div class="card stat-card p-3"><span class="text-muted"><?= $card[0] ?></span><strong class="display-6"><?= $counts[$card[1]] ?></strong><i class="fa-solid <?= $card[2] ?> text-<?= $card[3] ?>"></i></div></div>
    <?php endforeach; ?>
</div>
<div class="row g-4">
    <div class="col-lg-4"><div class="card p-4"><h2 class="h5">Slot Status</h2><canvas id="slotChart" data-chart='<?= e(json_encode($slotStats)) ?>'></canvas></div></div>
    <div class="col-lg-8"><div class="card p-4"><h2 class="h5">Recent Parking Activity</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Visitor</th><th>Plate</th><th>Slot</th><th>Status</th><th>Check-in</th></tr></thead><tbody><?php foreach ($recent as $row): ?><tr><td><?= e($row['full_name']) ?></td><td><?= e($row['plate_number']) ?></td><td><?= e($row['slot_code']) ?></td><td><span class="badge <?= $row['status'] === 'Active' ? 'badge-soft-warning' : 'badge-soft-success' ?>"><?= e($row['status']) ?></span></td><td><?= e($row['check_in']) ?></td></tr><?php endforeach; ?></tbody></table></div></div></div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
