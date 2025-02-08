<?php 
include '../layouts/session.php';
include '../layouts/config.php';


if ($_GET['action'] == 'get_banner') {
    //fetch data from users table
    $sql = "SELECT id,text,status,created_at FROM banner_text";
    $result = $pdo->prepare($sql);
    $result->execute();
    $all_users = $result->fetchAll();

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_users);
}

if ($_GET['action'] == 'delete_banner') {
    $id = $_POST['id'];

    $sql = "DELETE FROM `banner_text` WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
    
}

if ($_GET['action'] == 'change_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `banner_text` SET `status` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}

