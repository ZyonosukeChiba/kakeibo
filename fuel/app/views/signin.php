<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 

     <?php echo Asset::css('signin.css'); ?>
    <title>家計簿アプリ</title>
    
</head>
<body>
    
    

<div class="formContainer">
    <form action="demo/hello/public/original/auth3/" method="POST">
        <h1>新規登録</h1>
        <hr/>

        <div class="uiForm">
            <div class="formField">
                <label for="username">ユーザー名:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="formField">
                <label for="password">パスワード:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="formField">
                <label for="email">メールアドレス:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button class="submitButton">サインイン</button>
        </div>
    </form>
    </div>
    <form method="POST" action="/demo/hello/public/original/form3/">
                <button className="sign" type="submit">ログイン画面に戻る</button>
                </form>




</body>
</html>
