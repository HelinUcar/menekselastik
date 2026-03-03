<?php
header("content-type:text/html;charset=utf8");
define("Secure-MENEKSELASTIK-2025@!", true);
define("SITE", "pages/");
define("COMPONENTS", "components/");
require("../components/config.php");
ob_start();
session_start();


// JSON döneceğiz
header_remove();
header('Content-Type: application/json; charset=utf-8');

// action kontrolü
$action = $_GET['action'] ?? '';
if ($action === '') {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']);
    exit;
}

if ($action === 'get_tire_sizes') {

    try {
        $tire_id = (int)($_GET['tire_id'] ?? 0);
        if ($tire_id <= 0) {
            echo json_encode(["data" => []], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $sql = "SELECT 
                    t.model AS tire_model,
                    s.id,
                    CONCAT(s.width, '/', s.aspect_ratio, ' R', s.rim_diameter) AS size_text,
                    CONCAT(s.load_index, '/', s.speed_rating) AS load_speed
                FROM tire_sizes s
                INNER JOIN tires t ON t.id = s.tire_id
                WHERE s.tire_id = ?
                ORDER BY s.width, s.aspect_ratio, s.rim_diameter";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tire_id]); // ✅ parametre burada veriliyor

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // DataTables için direkt object array döndürebilirsin
        echo json_encode(["data" => $rows], JSON_UNESCAPED_UNICODE);
        exit;

    } catch (Throwable $e) {
        // gerçek hatayı görmek için geçici debug (prod’da kapat)
        echo json_encode([
            'status' => 'error',
            'message' => 'Veri alınırken hata oluştu.',
            'debug' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Geçersiz action.']);
exit;
?>