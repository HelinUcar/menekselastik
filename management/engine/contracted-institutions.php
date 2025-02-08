<?php
include '../layouts/session.php';
include '../layouts/config.php';


if ($_GET['action'] == 'get_contracted_institutions') {
    //fetch data from users table
    $sql = "SELECT * FROM `contracted_institutions`";
    $result = $pdo->prepare($sql);
    $result->execute();
    $all_contracted_institutions = $result->fetchAll();

    //close connection
    unset($pdo);
    

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_contracted_institutions);
}

if ($_GET['action'] == 'delete_contracted_institutions') {
    $id = $_POST['id'];
    //delete photo 
    $sql = "SELECT `photo` FROM `contracted_institutions` WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);
    $photo = $result->fetch();
    unlink('../' . $photo['photo']);

    $delete_sql = "DELETE FROM `contracted_institutions` WHERE `id` = ?";
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

    $sql = "UPDATE `contracted_institutions` SET `status` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}

if ($_GET['action'] == 'change_page_status') {
    $id = 2;
    $status = $_POST['status'];

    $sql = "UPDATE `general_assembly_form` SET `status` = ? WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$status, $id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}
