
<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'menekselastik');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8mb4");

//pdo connection
try {
    // Attempt to connect to MySQL database using PDO
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}



function turkceTarih($tarih)
{
    // Türkçe ay isimleri dizisi
    $aylar = array(
        '01' => 'Oca',
        '02' => 'Şub',
        '03' => 'Mar',
        '04' => 'Nis',
        '05' => 'May',
        '06' => 'Haz',
        '07' => 'Tem',
        '08' => 'Ağu',
        '09' => 'Eyl',
        '10' => 'Eki',
        '11' => 'Kas',
        '12' => 'Ara'
    );

    //saat ve tarihi ayır
    $tarih = explode(" ", $tarih);
    $newtarih = $tarih[0];


    // Gelen tarihi parçalara ayırıyoruz
    $parcalar = explode('-', $newtarih);
    // Parçaları Türkçe formatında birleştiriyoruz (Gün Ay Yıl)
    return $parcalar[2] . ' ' . $aylar[$parcalar[1]] . ' ' . $parcalar[0];
}



function kisalt($html, $word_limit)
{
    // Karakter setini UTF-8 olarak ayarlayalım
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html); // UTF-8 karakter setini kullanarak HTML'yi yükle

    // Tüm paragraf (p) etiketlerini alalım
    $paragraphs = $doc->getElementsByTagName('p');
    $text = "";

    // Paragraflardaki metni birleştir
    foreach ($paragraphs as $p) {
        $text .= $p->textContent . " ";
    }

    // Kelimelere göre sınırla (200 kelime)
    $words = explode(' ', trim($text));
    if (count($words) > $word_limit) {
        $words = array_slice($words, 0, $word_limit); // İlk 200 kelimeyi al
        $output = implode(' ', $words) . '...'; // Sonuna ... ekle
    } else {
        $output = implode(' ', $words); // Eğer 200'den az kelime varsa tamamını göster
    }

    // HTML'den arındırılmış ve kelime sınırlandırılmış metni döndür
    return "<p>" . $output . "</p>";
}

//seo settings array
$seo_settings_arr = [];
$get_seo_settings = $pdo->prepare("SELECT * FROM seo_settings WHERE id=?");
$get_seo_settings->execute([1]);
$seo_settings = $get_seo_settings->fetch(PDO::FETCH_ASSOC);

foreach ($seo_settings as $key => $value) {
    $seo_settings_arr[$key] = $value;
}












?>