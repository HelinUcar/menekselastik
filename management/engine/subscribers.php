<?php
include '../layouts/session.php';
include '../layouts/config.php';



if ($_GET['action'] == 'delete_subscriber') {
    $id = $_POST['id'];
    
    $delete_sql = "DELETE FROM `abonelik` WHERE `id` = ?";
    $delete_result = $pdo->prepare($delete_sql);
    $delete_result->execute([$id]);
    
    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}

