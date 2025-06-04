<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
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


// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CSRF token generation function
function generate_csrf_token()
{
    return bin2hex(random_bytes(32));
}

// CSRF token validation function
function validate_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Function to sanitize input data
function sanitize_input($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function permalink($data)
{
    // Girdi: $data= "PHP ile seo uyumlu linkler oluşturuyoruz."
    $find = array("/Ğ/", "/Ü/", "/Ş/", "/İ/", "/Ö/", "/Ç/", "/ğ/", "/ü/", "/ş/", "/ı/", "/ö/", "/ç/"); // türkçe karakterleri dizi içine alıyoruz
    $change = array("G", "U", "S", "I", "O", "C", "g", "u", "s", "i", "o", "c"); // türkçe karakterlerin dönüşeceği harfleri dizi içine alıyoruz
    $data = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/", " ", $data);
    $data = preg_replace($find, $change, $data); // yazımızda gelen türkçe karakterleri değiştiriyoruz.
    $data = preg_replace("/ +/", " ", $data);
    $data = preg_replace("/ /", "-", $data); // boşlukları '-' ile ayırıyoruz
    $data = preg_replace("/\s/", "", $data);
    $data = preg_replace("/[^A-Za-z0-9\-]/", "", $data);
    $data = strtolower($data); // tüm harfleri küçültüyoruz
    $data = preg_replace("/^-/", "", $data);
    $data = preg_replace("/-$/", "", $data);
    return $data; // seo uyumlu linkimiz oluşuyor.
    // Çıktı: $data ="php-ile-seo-uyumlu-linkler-olusturuyoruz"
}

function getFirstTwoSentences($html)
{
    // Metni UTF-8'e dönüştürelim
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

    // HTML etiketlerini kaldıralım ve temiz metni elde edelim
    $text = strip_tags($html);

    // Cümleleri ayırmak için nokta, ünlem veya soru işaretine göre bölelim
    $sentences = preg_split('/(?<=[.!?])\s+/', trim($text), 3); // İlk 3 cümleyi alalım

    // İlk iki cümleyi birleştir
    $output = $sentences[0] . (isset($sentences[1]) ? ' ' . $sentences[1] : '');

    // Temizlenmiş ve UTF-8'e uygun ilk iki cümleyi döndür
    return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
}

function getUserRole($user_id)
{
    global $pdo;
    $get_role_sql = "SELECT role_name FROM roles WHERE role_id = :role_id";
    if ($stmt = $pdo->prepare($get_role_sql)) {
        $stmt->bindParam(':role_id', $user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ucfirst($row["role_name"]);
    }
}

function youtubeToEmbed($url)
{
    if (strpos($url, 'watch?v=') !== false) {
        return str_replace('watch?v=', 'embed/', $url);
    }
    return $url;
}

$gmailid = ''; // YOUR gmail email
$gmailpassword = ''; // YOUR gmail password
$gmailusername = ''; // YOUR gmail User name
