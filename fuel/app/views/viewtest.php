<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿アプリ</title>
    
</head>
<body>
    
    <h1>家計簿アプリ</h1>
    <form method="POST" action="/demo/hello/public/original/logout/">
        <input type="hidden" value="1">
        <input type="submit" value="ログアウト">
    </form>
    <?php 
$email = Session::get('email');
if($email != null) {
    echo $email . 'さんようこそ';
}
?>

<h2>支出</h2>
<form method="POST" action="/demo/hello/public/original/kform/">
    <label for="date">日付:</label>
    <input type="date" name="date" id="date"><br>
    <label for="title">分類:</label>
    <input type="text" name="title" list="payment-select" placeholder="テキスト入力もしくはダブルクリック" autocomplete="off"><br>
    <datalist id="payment-select">
        <option value="">please choose an option</option>
        <option value="food">食費</option>
        <option value="utility">光熱費</option>
        <option value="entertainment">交際費</option>
        <option value="card">クレジットカード</option>
    </datalist>
    <label for="price">金額:</label>
    <input type="text" id="price" name="price">円
    <p id="aa"></p>
    <input type="submit" value="送信">
</form>

<h2>収入</h2>
<form method="POST" action="/demo/hello/public/original/income_form/">
    <label for="date2">日付:</label>
    <input type="date" name="date2" id="date2"><br>
    <label for="income_name">収入元:</label>
    <input type="text" name="income_name"><br>
    <label for="price2">金額:</label>
    <input type="text" id="price2" name="price2">円
    <p id="aaa"></p>
    <input type="submit" value="送信">
</form>

<p>月ごとの収支を見る</p>
<form method="POST" action="/demo/hello/public/original/month/">
    <input type="month" name="month" id="month">
    <input type="submit" value="送信">
</form>

<?php 
$month = Session::get('month');
$out = Session::get('out');
$in = Session::get('in');

echo $month;
echo $out;

echo '<h3>支出</h3>';

$out = 0;
$result = DB::select('id', 'date', 'title', 'price')
    ->from('kaeibo')
    ->where('email', '=', $email)
    ->and_where(DB::expr("DATE_FORMAT(date, '%Y-%m')"), '=', $month)
    ->execute()
    ->as_array();

echo '<table>';
echo '<tr><th>日付</th><th>分類</th><th>金額</th><th>削除</th></tr>';
foreach ($result as $row) {
    $id = $row['id'];
    $out += $row['price'];
    echo '<tr>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['price'] . '円</td>';
    echo '<td>
        <form method="POST" action="/demo/hello/public/original/delete/">
            <input type="hidden" name="delete_id" value="' . $id . '">
            <input type="submit" value="削除">
        </form>
    </td>';
    echo '</tr>';
}
echo '</table>';

echo '<p class="total">' . $out . '円の出費です</p>';

echo '<h2>収入</h2>';

$in = 0;
$result = DB::select('id', 'date2', 'income_name', 'price2')
    ->from('income')
    ->where('email', '=', $email)
    ->and_where(DB::expr("DATE_FORMAT(date2, '%Y-%m')"), '=', $month)
    ->execute()
    ->as_array();

echo '<table>';
echo '<tr><th>日付</th><th>収入元</th><th>金額</th><th>削除</th></tr>';
foreach ($result as $row) {
    $id2 = $row['id'];
    $in += $row['price2'];
    echo '<tr>';
    echo '<td>' . $row['date2'] . '</td>';
    echo '<td>' . $row['income_name'] . '</td>';
    echo '<td>' . $row['price2'] . '円</td>';
    echo '<td>
        <form method="POST" action="/demo/hello/public/original/delete2/">
            <input type="hidden" name="delete_id2" value="' . $id2 . '">
            <input type="submit" value="削除">
        </form>
    </td>';
    echo '</tr>';
}
echo '</table>';

echo '<p class="total">' . $in . '円の収入です</p>';

echo '<h2>収支</h2>';
$all = $in - $out;
echo '<p class="total">合計は' . $all . '円です</p>';
?>

</body>
</html>
