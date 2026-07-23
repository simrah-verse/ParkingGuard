<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();
verify_csrf();
$pageTitle = 'Visitors';
$edit = null;
if (isset($_GET['delete'])) { db()->prepare('DELETE FROM visitors WHERE id=?')->execute([(int)$_GET['delete']]); flash('success','Visitor deleted.'); redirect('/pages/visitors.php'); }
if (isset($_GET['edit'])) { $stmt=db()->prepare('SELECT * FROM visitors WHERE id=?'); $stmt->execute([(int)$_GET['edit']]); $edit=$stmt->fetch(); }
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $data=[trim($_POST['full_name']),trim($_POST['phone']),trim($_POST['email']),trim($_POST['purpose']),trim($_POST['host_name'])];
    if (!empty($_POST['id'])) { $data[]=(int)$_POST['id']; db()->prepare('UPDATE visitors SET full_name=?, phone=?, email=?, purpose=?, host_name=? WHERE id=?')->execute($data); flash('success','Visitor updated.'); }
    else { db()->prepare('INSERT INTO visitors (full_name, phone, email, purpose, host_name) VALUES (?,?,?,?,?)')->execute($data); flash('success','Visitor added.'); }
    redirect('/pages/visitors.php');
}
$visitors=db()->query('SELECT * FROM visitors ORDER BY created_at DESC')->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<div class="row g-4"><div class="col-lg-4"><div class="card p-4"><h1 class="h4"><?= $edit ? 'Edit Visitor' : 'Add Visitor' ?></h1><form method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>"><div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="full_name" value="<?= e($edit['full_name'] ?? '') ?>" required></div><div class="mb-3"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($edit['phone'] ?? '') ?>" required></div><div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($edit['email'] ?? '') ?>"></div><div class="mb-3"><label class="form-label">Purpose</label><input class="form-control" name="purpose" value="<?= e($edit['purpose'] ?? '') ?>" required></div><div class="mb-3"><label class="form-label">Host name</label><input class="form-control" name="host_name" value="<?= e($edit['host_name'] ?? '') ?>" required></div><button class="btn btn-primary w-100">Save Visitor</button></form></div></div><div class="col-lg-8"><div class="card p-4"><h2 class="h4">Visitor Directory</h2><div class="table-responsive"><table class="table"><thead><tr><th>Name</th><th>Phone</th><th>Purpose</th><th>Host</th><th class="no-print">Actions</th></tr></thead><tbody><?php foreach($visitors as $v): ?><tr><td><?= e($v['full_name']) ?></td><td><?= e($v['phone']) ?></td><td><?= e($v['purpose']) ?></td><td><?= e($v['host_name']) ?></td><td class="no-print"><a class="btn btn-sm btn-outline-primary" href="?edit=<?= $v['id'] ?>">Edit</a> <a class="btn btn-sm btn-outline-danger" data-confirm="Delete this visitor?" href="?delete=<?= $v['id'] ?>">Delete</a></td></tr><?php endforeach; ?></tbody></table></div></div></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
