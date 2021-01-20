<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: http://localhost/final/", true, 301);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="index.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div v-show="showAddModal" class="modal-container">
            <div class="modal">
                <label for="begin" class="input-title">開始日時</label>
                <input v-model="begin" type="datetime-local" name="begin" id="begin" class="modal-input time-input">
                <label for="end" class="input-title">終了日時</label>
                <input v-model="end" type="datetime-local" name="end" id="end" class="modal-input time-input">
                <label for="title" class="input-title">タイトル</label>
                <textarea v-model="title" name="title" id="title" cols="90" rows="1" class="modal-input textarea"></textarea>
                <label for="content" class="input-title">内容</label>
                <textarea v-model="content" name="content" id="content" cols="90" rows="5" class="modal-input textarea"></textarea>
                <div class="modal-footer">
                    <label for="cancel-register-btn" class="btn">キャンセル</label>
                    <button hidden id="cancel-register-btn" @click="cancel()"></button>
                    <label for="register-btn" class="btn">登録</label>
                    <button @click="register" hidden id="register-btn"></button>
                </div>
            </div>
        </div>
        <div v-show="showEditModal" class="modal-container">
            <div class="modal">
                <label for="begin" class="input-title">開始日時</label>
                <input v-model="begin" type="datetime-local" name="begin" id="begin" class="modal-input time-input">
                <label for="end" class="input-title">終了日時</label>
                <input v-model="end" type="datetime-local" name="end" id="end" class="modal-input time-input">
                <label for="title" class="input-title">タイトル</label>
                <textarea v-model="title" name="title" id="title" cols="90" rows="1" class="modal-input textarea"></textarea>
                <label for="content" class="input-title">内容</label>
                <textarea v-model="content" name="content" id="content" cols="90" rows="5" class="modal-input textarea"></textarea>
                <div class="modal-footer">
                    <label for="cancel-update-btn" class="btn">キャンセル</label>
                    <button hidden id="cancel-update-btn" @click="cancel()"></button>
                    <label for="update-btn" class="btn">更新</label>
                    <button @click="update()" hidden id="update-btn"></button>
                </div>
            </div>
        </div>
        <header class="header">
            <h1 class="header-title">Todoリスト</h1>
            <label for="add" class="btn">追加</label>
            <button id="add" hidden @click="showAddModal = true"></button>
        </header>
        <main>
            <p class="list-title">未達成タスク</p>
            <p v-if="nonCheckedTodos.length == 0" class="description">
                未達成のタスクはありません。
            </p>
            <div class="list-item" v-for="todo in nonCheckedTodos" key="todo.id">
                <div>
                    <p class="date">{{todo.begin | dateFormat}} ~ {{todo.end | dateFormat}}</p>
                    <div class="list-item-container">
                        <div class="list-item-title-container">
                            <i class="far fa-check-circle fa-2x icon" @click="toggle(todo.id)"></i>
                            <p class="title">{{todo.title}}</p>
                        </div>
                        <p class="content">{{todo.content}}</p>
                    </div>
                </div>
                <div class="list-item-right">
                    <i class="far fa-edit fa-lg icon" @click="editTodo(todo)"></i>
                    <i class="far fa-trash-alt fa-lg icon" @click="remove(todo.id)"></i>
                </div>
            </div>
            <p class="list-title">達成済みタスク</p>
            <p v-if="checkedTodos.length == 0" class="description">
                達成済みのタスクはありません。
            </p>
            <div class="list-item" v-for="todo in checkedTodos" key="todo.id">
                <div>
                    <p class="date">{{todo.begin | dateFormat}} ~ {{todo.end | dateFormat}}</p>
                    <div class="list-item-container">
                        <div class="list-item-title-container">
                            <i class="far fa-check-circle fa-2x icon checked" @click="toggle(todo.id)"></i>
                            <p class="title">{{todo.title}}</p>
                        </div>
                        <p class="content">{{todo.content}}</p>
                    </div>
                </div>
                <div class="list-item-right">
                    <i class="far fa-edit fa-lg icon" @click="editTodo(todo)"></i>
                    <i class="far fa-trash-alt fa-lg icon" @click="remove(todo.id)"></i>
                </div>
            </div>
        </main>
    </div>
</body>

</html>