<?php 
include '../layouts/session.php';
include '../layouts/config.php';

if ($_GET['action'] == 'get_roles') {
    // Fetch data from roles table with user and permission counts
    $sql = "
        SELECT 
            r.role_id, 
            r.role_name, 
            COUNT(DISTINCT u.id) AS user_count, 
            COUNT(DISTINCT rp.permission_id) AS permission_count
        FROM roles r
        LEFT JOIN users u ON r.role_id = u.role_id
        LEFT JOIN role_permissions rp ON r.role_id = rp.role_id
        GROUP BY r.role_id, r.role_name;
    ";

    $result = $pdo->prepare($sql);
    $result->execute();
    $all_roles = $result->fetchAll(PDO::FETCH_ASSOC);

    // Close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_roles);
}


if ($_GET['action'] == 'delete_role') {
    $role_id = $_POST['id'];

    // Role atanmış kullanıcı olup olmadığını kontrol et
    $sql = "SELECT COUNT(*) FROM users WHERE role_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$role_id]);
    $user_count = $stmt->fetchColumn();

    if ($user_count == 0) {
        // Rolü sil
        $sql = "DELETE FROM roles WHERE role_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$role_id]);

        // İlişkili izinleri sil
        $sql = "DELETE FROM role_permissions WHERE role_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$role_id]);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

?>
