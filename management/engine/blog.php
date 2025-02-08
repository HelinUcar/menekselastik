<?php
include '../layouts/session.php';
include '../layouts/config.php';


if ($_GET['action'] == 'get_blogs') {
    //fetch data from users table
    $sql = "SELECT * FROM `blogs`";
    $result = $pdo->prepare($sql);
    $result->execute();
    $all_blogs = $result->fetchAll();

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_blogs);
}

if ($_GET['action'] == 'delete_blog') {
    $id = $_POST['id'];
    //delete photo 
    $sql = "SELECT `photo` FROM `blogs` WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);
    $photo = $result->fetch();
    unlink('../' . $photo['photo']);

    $delete_sql = "DELETE FROM `blogs` WHERE `id` = ?";
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

    $sql = "UPDATE `blogs` SET `status` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}
