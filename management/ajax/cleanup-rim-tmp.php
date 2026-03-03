<?php
header('Content-Type: application/json; charset=utf-8');
include "../layouts/session.php";
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function rrmdir_safe($dir) {
    if (!is_dir($dir)) return;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $item) {
        $item->isDir() ? @rmdir($item->getRealPath()) : @unlink($item->getRealPath());
    }
    @rmdir($dir);
}

$tmpDirAbs = __DIR__ . "/../../uploads/tmp/rims/" . session_id() . "/";
rrmdir_safe($tmpDirAbs);

echo json_encode(["status" => "ok"]);
