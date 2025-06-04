<?php
include '../layouts/session.php';
include '../layouts/config.php';

// Ensure action is set
if (!isset($_GET['action'])) {
    die(json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']));
}
if ($_GET['action'] == 'get_users') {
    try {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.role_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = []; // Burada dizi tanımlanmalı
        foreach ($all_users as $row) {
            $data[] = [
                "id" => $row["id"],
                "username" => $row["username"],
                "usersurname" => $row["usersurname"],
                "useremail" => $row["useremail"],
                "role_name" => ucfirst($row["role_name"]),
                "userphoto" => $row["userphoto"],
                "created_at" => $row["created_at"],
            ];
        }

        // JSON formatında DataTables için gönder
        header('Content-Type: application/json');
        echo json_encode(["data" => $data]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Veri alınırken hata oluştu.']);
    }
    exit;
}

if ($_GET['action'] == 'delete_user') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        die(json_encode(['status' => 'error', 'message' => 'Geçersiz CSRF token.']));
    }

    // Validate and sanitize user ID
    if (!isset($_POST['id']) || !filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        die(json_encode(['status' => 'error', 'message' => 'Geçersiz kullanıcı ID.']));
    }

    $id = $_POST['id'];

    try {
        // Önce kullanıcının fotoğrafını al
        $stmtSelect = $pdo->prepare("SELECT userphoto FROM users WHERE id = :id");
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Dosya varsa ve sunucuda bulunuyorsa sil
        if ($user && !empty($user['userphoto'])) {
            $photoPath = '../' . $user['userphoto'];
            if (file_exists($photoPath)) {
                if (!unlink($photoPath)) {
                    throw new Exception("Fotoğraf silinemedi: $photoPath");
                }
            }
        }
        // Kullanıcıyı sil
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['csrf_token'] = generate_csrf_token();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        http_response_code(500); // Tarayıcıya 500 hatası olarak döndür
        echo json_encode([
            'status' => 'error',
            'message' => 'Hata: ' . $e->getMessage()
        ]);
    }

    exit;
}
