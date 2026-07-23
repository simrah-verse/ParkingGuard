<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();
$from=$_GET['from']??date('Y-m-01');$to=$_GET['to']??date('Y-m-d');
$stmt=db()->prepare('SELECT vi.full_name, vi.phone, ve.plate_number, ve.vehicle_type, ps.slot_code, pr.check_in, pr.check_out, pr.status, pr.fee FROM parking_records pr JOIN visitors vi ON vi.id=pr.visitor_id JOIN vehicles ve ON ve.id=pr.vehicle_id JOIN parking_slots ps ON ps.id=pr.slot_id WHERE DATE(pr.check_in) BETWEEN ? AND ? ORDER BY pr.check_in DESC');
$stmt->execute([$from,$to]);
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=parkingguard-report-'.$from.'-to-'.$to.'.csv');
$out=fopen('php://output','w');
fputcsv($out,['Visitor','Phone','Plate Number','Vehicle Type','Slot','Check In','Check Out','Status','Fee']);
foreach($stmt as $row){fputcsv($out,$row);}fclose($out);
