<?php
include '../layouts/session.php';
include '../layouts/config.php';


if ($_GET['action'] == 'get_users') {
    //fetch data from users table
    $sql = "SELECT id,userphoto,username, usersurname, userwork, usertitle, userorder, created_at FROM committee_user";
    $result = $pdo->prepare($sql);
    $result->execute();
    $all_users = $result->fetchAll();

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($all_users);
}

if ($_GET['action'] == 'delete_user') {
    $id = $_POST['id'];

    $sql = "DELETE FROM `committee_user` WHERE `id` = ?";
    $result = $pdo->prepare($sql);
    $result->execute([$id]);

    //close connection
    unset($pdo);

    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
}
