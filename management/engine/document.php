<?php
include '../layouts/session.php';
include '../layouts/config.php';


if ($_GET['action'] == 'get_document') {
    //fetch data from document table
    $sql = "SELECT * FROM `documents`";
    $result = $pdo->prepare($sql);
    $result->execute();
    $all_document = $result->fetchAll();

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_document);
}

if ($_GET['action'] == 'delete_document') {
    $id = $_POST['id'];
    //delete photo 
    $sql = "SELECT `file` FROM `documents` WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);
    $photo = $result->fetch();
    unlink('../' . $photo['file']);

    $delete_sql = "DELETE FROM `documents` WHERE `id` = ?";
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

    $sql = "UPDATE `documents` SET `status` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}
