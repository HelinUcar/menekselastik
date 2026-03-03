<?php
header('Content-Type: application/json; charset=utf-8');

require_once "../layouts/config.php"; 
include "../layouts/session.php"; // admin kontrolü varsa

// Güvenlik
// if (empty($_FILES['file']['tmp_name'])) {
//     echo json_encode(["status" => "error", "message" => "Dosya yok"]);
//     exit;
// }

$tmp  = $_FILES['file']['tmp_name'];
$name = $_FILES['file']['name'];
$size = (int)$_FILES['file']['size'];

$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

if (!in_array($ext, ["jpg", "jpeg", "png"], true)) {
    echo json_encode(["status" => "error", "message" => "Geçersiz dosya formatı: $ext"]);
    exit;
}

if ($size > 15 * 1024 * 1024) {
    echo json_encode(["status" => "error", "message" => "Dosya çok büyük"]);
    exit;
}

if (@getimagesize($tmp) === false) {
    echo json_encode(["status" => "error", "message" => "Resim değil"]);
    exit;
}

// Upload dizini
$uploadDir = "../../uploads/rims/gallery/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

$fileName = uniqid("rim-gal-", true) . "." . $ext;
$target = $uploadDir . $fileName;

if (!move_uploaded_file($tmp, $target)) {
    echo json_encode(["status" => "error", "message" => "Yükleme başarısız"]);
    exit;
}

// Frontend’e dönecek path
$publicPath = "../uploads/rims/gallery/" . $fileName;

echo json_encode([
    "status" => "ok",
    "path"   => $publicPath
]);



