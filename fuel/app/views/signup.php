<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <?php echo Asset::css('signin.css'); ?>
    <title>サインイン</title>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
</head>

<body>
    <div id="root"></div>




    <script type="text/babel">

        const App = () => {
            return (
                <div>
                    <div class="formContainer">
                        <form action="demo/hello/public/original/signup/" method="POST">
                            <h1>新規登録</h1>
                            <hr />
                            <div class="uiForm">
                                <div class="formField">
                                    <label for="email">メールアドレス:</label>
                                    <input type="email" name="email" id="email" required />
                                </div>
                                <div class="formField">
                                    <label for="password">パスワード:</label>
                                    <input type="password" name="password" id="password" required />
                                </div>
                                <button class="submitButton">サインアップ</button>
                            </div>
                        </form>
                    </div>
                    <div class="ButtonA-parent">
                    <form method="POST" action="/demo/hello/public/original/login/">
                        <button className="sign" type="submit" class="buttonA">ログイン画面に戻る</button>
                    </form>
                    </div>

                </div>
            )
        }

        const container = document.getElementById("root");
        const root = ReactDOM.createRoot(container);
        root.render(<App />);

    </script>



</body>

</html>

