<?php
session_start();
require_once("../config.php");

if (!isset($_POST["user"]) || !isset($_POST["password"])) {
    header("Location: http://localhost/final/", true, 301);
    exit();
}

$dbname = DBNAME;
$host = HOST;
$user = $_POST["user"];
$password = $_POST["password"];

try {
    $pdo = new PDO("mysql:dbname={$dbname};host={$host}", DBUSER, DBPASS);
    $sql = "SELECT password FROM users WHERE user = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user', $user, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $hash = $row["password"];

    if (!password_verify($password, $hash)) {
        header("Location: http://localhost/final/", true, 301);
        exit();
    } else {
        echo "seikou";
        $_SESSION["user"] = $user;
        header("Location: http://localhost/final/home/", true, 301);
        exit();
    }
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
