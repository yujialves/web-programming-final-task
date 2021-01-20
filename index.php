<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: http://localhost/final/home/", true, 301);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="index.js" defer></script>
    <link rel="stylesheet" href="style.css">
    </link>
    <title>ログイン</title>
</head>

<body>
    <div id="app" class="container">
        <form v-bind:action="formAction" method="POST" class="form">
            <h1 v-if="inLogin">{{title}}</h1>
            <h1 v-else="">登録</h1>
            <input v-model="user" type="text" name="user" id="user" placeholder="ユーザ名" class="input">
            <input v-model="password" type="password" name="password" id="password" placeholder="パスワード" class="input">
            <input v-model="passwordToConfirm" v-show="!inLogin" type="password" placeholder="パスワードの確認" class="input">
            <label for="button" class="button">{{title}}</label>
            <button id="button" hidden v-bind:disabled="disabled"></button>
            <p @click="inLogin = !inLogin" class="bottom-text">{{bottomText}}</p>
        </form>
    </div>
</body>

</html>