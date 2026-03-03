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

if ($action === 'get_rim_specs') {

    try {
        $rim_id = (int)($_GET['rim_id'] ?? 0);
        if ($rim_id <= 0) {
            echo json_encode(["data" => []], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $sql = "SELECT * FROM rim_specs WHERE rim_id = ? ORDER BY diameter";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rim_id]); // ✅ parametre burada veriliyor

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
