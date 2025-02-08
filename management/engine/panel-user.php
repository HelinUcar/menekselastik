<?php
include '../layouts/session.php';
include '../layouts/config.php';

// Ensure action is set
if (!isset($_GET['action'])) {
    die(json_encode(['status' => 'error', 'message' => 'Geçersiz istek.']));
}
if ($_GET['action'] == 'get_users') {
    try {
        $sql = "SELECT id, useremail, username, usersurname, created_at FROM users";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return as JSON
        header('Content-Type: application/json');
        echo json_encode($all_users);
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
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['csrf_token'] = generate_csrf_token();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Silme işlemi sırasında hata oluştu.']);
    }
    exit;
}
