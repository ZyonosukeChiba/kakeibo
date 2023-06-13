// ログインフォームのHTML
<form action="login.php" method="POST">
    <label for="email">メールアドレス:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">パスワード:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="ログイン">
</form>


<?php
// データベース接続情報
$host = 'localhost';
$dbname = 'fuelphp';
$username = 'root';
$password = '';

// フォームからの入力値を取得
$email = $_POST['email'];
$password = $_POST['password'];

// データベースに接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    die();
}

// ユーザ認証
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // 認証成功の処理
    session_start();
    $_SESSION['user_id'] = $user['id'];
    header("Location: welcome.php"); // ログイン後のページにリダイレクト
    exit();
} else {
    // 認証失敗の処理
    echo "メールアドレスまたはパスワードが間違っています";
}
?>

