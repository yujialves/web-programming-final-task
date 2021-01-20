<?php
require_once("../config.php");

if (!isset($_POST["user"]) || !isset($_POST["password"])) {
    header("Location: http://localhost/final/", true, 301);
    exit();
}

$dbname = DBNAME;
$host = HOST;
$user = $_POST["user"];
$password = $_POST["password"];
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:dbname={$dbname};host={$host}", DBUSER, DBPASS);
    $sql = "INSERT INTO users (user, password) VALUES (:user, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $user, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: http://localhost/final/", true, 301);
    exit();
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
