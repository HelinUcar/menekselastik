<?php
header('Content-Type: application/json; charset=utf-8');
include "../layouts/session.php";

$path = trim($_POST['path'] ?? '');
if ($path === '') { echo json_encode(["status"=>"error"]); exit; }

// ✅ güvenlik: sadece izin verdiğimiz klasörden sil
if (strpos($path, "../uploads/rims/gallery/") !== 0) {
  echo json_encode(["status"=>"error","message"=>"Yetkisiz yol"]); exit;
}

// absolute path
$abs = __DIR__ . "/../../" . ltrim($path, "../");

// extra güvenlik
$real = realpath($abs);
$base = realpath(__DIR__ . "/../../uploads/rims/gallery/");
if (!$real || strpos($real, $base) !== 0) {
  echo json_encode(["status"=>"error","message"=>"Geçersiz yol"]); exit;
}

if (file_exists($real)) @unlink($real);

echo json_encode(["status"=>"ok"]);

