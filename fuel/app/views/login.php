<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
    <title>家計簿アプリログイン</title>
</head>
<body>
    <form action="/demo/hello/public/original/yap2/">
    <button id="signin" >新規登録</button>
</form>


    <button id="login">ログイン</button>


<?php

$email = Input::post('email'); // フォームからemailの値を取得

		\Session::set('email', $email); // セッションにemailを保存
?>








</body>
</html>