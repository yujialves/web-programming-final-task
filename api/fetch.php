<?php

session_start();
require_once("../config.php");

if (!isset($_SESSION["user"])) {
    header("Location: http://localhost/final/", true, 301);
    exit();
}

$dbname = DBNAME;
$host = HOST;

try {
    $pdo = new PDO("mysql:dbname={$dbname};host={$host}", DBUSER, DBPASS);
    $sql = "SELECT id FROM users WHERE user = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $_SESSION["user"], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row["id"];

    $sql = "SELECT * FROM todos WHERE user_id = :id ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($rows);
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
