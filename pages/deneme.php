<?php
$api_key = $seo_settings_arr['google_api_key'];
$place_id = $seo_settings_arr['place_id'];

// Google Places API URL'si (Yorumlar + Fotoğraflar dahil edildi)
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id=$place_id&fields=name,rating,reviews,photos&language=tr&key=$api_key";

// API'den veri çek
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
curl_close($ch);

$response = json_decode($res, true);

// Hata kontrolü
if ($response['status'] !== "OK") {
    die("API Hatası: " . $response['status'] . " - " . ($response['error_message'] ?? ""));
}

// Yorumları ve fotoğrafları al
$reviews = $response['result']['reviews'] ?? [];
$photos = $response['result']['photos'] ?? [];

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Yorumları</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .review { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .review:last-child { border-bottom: none; }
        .author { font-weight: bold; }
        .rating { color: gold; }
        .photo { margin: 10px 0; max-width: 100%; height: auto; }
    </style>
</head>
<body>

<h2>İşletme Yorumları</h2>

<?php foreach ($reviews as $review): ?>
    <div class="review">
        <p class="author"><?= htmlspecialchars($review['author_name']) ?></p>
        <p class="rating">⭐ <?= $review['rating'] ?>/5</p>
        <p><?= htmlspecialchars($review['text']) ?></p>
    </div>
<?php endforeach; ?>

<h2>İşletme Fotoğrafları</h2>

<?php foreach ($photos as $photo): ?>
    <?php 
        $photo_reference = $photo['photo_reference'];
        $photo_url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=$photo_reference&key=$api_key";
    ?>
    <img src="<?= $photo_url ?>" class="photo" alt="İşletme Fotoğrafı">
<?php endforeach; ?>

</body>
</html>
