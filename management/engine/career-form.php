<?php
include '../layouts/session.php';
include '../layouts/config.php';



if ($_GET['action'] == 'delete_form') {
    $id = $_POST['id'];


    $delete_sql = "DELETE FROM `career` WHERE `id` = ?";
    $delete_result = $pdo->prepare($delete_sql);
    $delete_result->execute([$id]);
    
    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}

if ($_GET['action'] == 'change_status') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `career` SET `seen` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}
