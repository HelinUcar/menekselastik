<?php
define("Secure-MENEKSELASTIK-2025@!", true);
header('Content-Type: application/json'); // JSON formatı

include '../components/config.php';

// Ensure action is set
if (!isset($_GET['action']) || $_GET['action'] !== 'get_comments') {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']);
    exit;
}


$api_key = $seo_settings_arr['google_api_key'];
$place_id = $seo_settings_arr['place_id'];

// Google Places API URL'si (Yorumlar + Kullanıcı Fotoğrafları)
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$place_id&fields=name,rating,reviews&language=tr&key=$api_key";

// API'den veri çek
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

$response = json_decode($res, true);

// Hata kontrolü
if ($response['status'] !== "OK") {
    echo json_encode(["status" => "error", "message" => $response['error_message'] ?? "Bilinmeyen hata"]);
    exit;
}

// Yorumları JSON olarak döndür
echo json_encode([
    "status" => "success",
    "reviews" => $response['result']['reviews'] ?? []
]);
exit;


