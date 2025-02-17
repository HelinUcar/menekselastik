<?php
define("Secure-MENEKSELASTIK-2025@!", true);
include '../components/config.php';

// Ensure action is set
if (!isset($_GET['action'])) {
    die(json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']));
}

if ($_GET['action'] == 'get_comments') {
    $api_key = $seo_settings_arr['google_api_key'];
    $place_id = $seo_settings_arr['place_id'];
    $url = "https://maps.googleapis.com/maps/api/place/details/json?key=$api_key&place_id=$place_id";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);

    $response = json_decode($res, true);
    print_r($response);
}
