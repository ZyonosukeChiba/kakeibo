<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <?php echo Asset::css('signin.css'); ?>
  <title>ログイン</title>
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
      <div className="formContainer">
        <form action="demo/hello/public/original/login/" method="POST">
          <h1>ログインフォーム</h1>
          <hr/>
          <div className="uiForm">
            <div className="formField">
              <label>メールアドレス</label>
              <input type="text" name="email1" id="email1" required></input>
            </div>
            <div className="formField">
              <label>パスワード</label>
              <input type="password" name="password1" id="password1" required></input>
            </div>
            <button className="submitButton">ログイン</button>  
          </div>
        </form>

      </div>
      <form method="POST" action="/demo/hello/public/original/signup/">
                <button className="sign" type="submit" >サインアップする</button>
                </form>
    </div>
   )
}

const container = document.getElementById("root");
const root = ReactDOM.createRoot(container);
root.render(<App />);

</script>
       

  
</body>
</html>