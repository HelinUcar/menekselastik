<?php
include '../layouts/session.php';
include '../layouts/config.php';

// Ensure action is set
if (!isset($_GET['action'])) {
    die(json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']));
}

if ($_GET['action'] == 'get_rims') {
    try {
        $sql = "
            SELECT 
                r.id,
                r.photo,
                r.brand,
                r.model
            FROM rims r
            ORDER BY r.id DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rims = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($rims as $row) {
            $data[] = [
                "id" => (int)$row["id"],
                "photo" => $row["photo"],                 // örn: ../uploads/rims/xxx.jpg
                "brand" => $row["brand"] ?? "",
                "model" => $row["model"] ?? ""
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'error', 'message' => 'Veri alınırken hata oluştu.'], JSON_UNESCAPED_UNICODE);
    }
    exit;
}


if ($_GET['action'] == 'delete_tire') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        die(json_encode(['status' => 'error', 'message' => 'Geçersiz CSRF token.']));
    }

    // Validate and sanitize tire ID
    if (!isset($_POST['id']) || !filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        die(json_encode(['status' => 'error', 'message' => 'Geçersiz lastik ID.']));
    }

    $id = $_POST['id'];

    try {
        // Önce lastik fotoğrafını al
        $stmtSelect = $pdo->prepare("SELECT photo FROM tires WHERE id = :id");
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtSelect->execute();
        $tire = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Dosya varsa ve sunucuda bulunuyorsa sil
        if ($tire && !empty($tire['photo'])) {
            $filePath = '../uploads/tires/' . $tire['photo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // 1. İlişkili vehicle_type kayıtlarını sil
        $stmtDelVehicleTypes = $pdo->prepare("DELETE FROM tire_vehicle_type WHERE tire_id = :id");
        $stmtDelVehicleTypes->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtDelVehicleTypes->execute();

        // 2. Lastiği sil
        $stmt = $pdo->prepare("DELETE FROM tires WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['csrf_token'] = generate_csrf_token();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Hata: ' . $e->getMessage()
        ]);
    }

    exit;
}
