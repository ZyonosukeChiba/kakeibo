<!DOCTYPE html>
<html>
<head>
    <title>新規登録</title>
</head>
<body>
    <h1>新規登録</h1>
    <form action="demo/hello/public/original/auth3/" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" id="email">
        <br>
        <input type="submit" value="登録">

    </form>

    <?php
    // Session::instance()->start();
    // $email = Input::post('email'); // フォームからemailの値を取得
    // Session::set('email', $email); 
?>

</body>
</html>
