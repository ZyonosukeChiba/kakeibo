<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 

     <?php echo Asset::css('styles.css'); ?>
     <?php echo Asset::js('view.js'); ?>
    <title>家計簿アプリ</title>
    
</head>
<body>

    <?php 
        if(Auth::check()){
     $email = Session::get('email');
     if($email != null) {
         echo $email . 'さんようこそ';
     }
    else{'ログインしていません';}}
     ?>
    
        <h1>家計簿アプリ</h1>
        <div class="button">
            
                <form method="POST" action="/demo/hello/public/original/c1/">  
                <button type="submit">グラフを見る</button>
                </form>
        

                <form method="POST" action="/demo/hello/public/original/logout/">
                <button type="submit">ログアウト</button>
                </form>

        
                <form method="POST" action="/demo/hello/public/original/signout/">
                <input type="hidden" name="email" value="<?php $email = Session::get('email');
                echo htmlspecialchars($email); ?>">
                   <button type="submit">退会する</button>
                </form>

         </form>
         </div>
       

<div class="formContainer">
    <h2>支出</h2>
    <form method="POST" action="/demo/hello/public/original/kform/">
        <div class="uiForm">
            <div class="formField">
                <label for="date">日付:</label>
                <input type="date" name="date" id="date"><br>
            </div>
        </div>
        <div class="formField">
            <label for="title">分類:</label>
            <input type="text" name="title" list="payment-select" placeholder="テキスト入力もしくはダブルクリック" autocomplete="off" data-bind="value :k,valueUpdate:'input"/><br>
            <datalist id="payment-select">
                <option value="">please choose an option</option>
                <option value="食費">食費</option>
                <option value="光熱費">光熱費</option>
                <option value="交際費">交際費</option>
                <option value="クレジットカード">クレジットカード</option>
            </datalist>
        </div>
        <div class="formField">
            <label for="price">金額:円</label>
            <input type="text" id="price" name="price" data-bind="value :p,valueUpdate:'input"/>
        </div>
        <input type="submit" value="送信" >
    </form>
</div>

<div class="formContainer">
    <h2>収入</h2>
    <form method="POST" action="/demo/hello/public/original/income_form/">
        <div class="uiForm">
            <div class="formField">
                <label for="date2">日付:</label>
                <input type="date" name="date2" id="date2"><br>
            </div>
        </div>
        <div class="formField">
            <label for="income_name">収入元:</label>
            <input type="text" name="income_name"><br>
        </div>
        <div class="formField">
            <label for="price2">金額:円</label>
            <input type="text" id="price2" name="price2">円
        </div>
        <input type="submit" value="送信">
    </form>
</div>


 
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
echo '<tr><th>日付</th><th>分類</th><th>金額</th><th>削除</th><th>編集</th></tr>';
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
    echo '<td>
    <form method="POST" action="/demo/hello/public/original/edit/">
        <input type="hidden" name="edit_id" value="' . $id . '">
        <input type="submit" value="編集" >
        </form>

</td> ';
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
echo '<tr><th>日付</th><th>収入元</th><th>金額</th><th>削除</th><th>編集</th></tr>';
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

    echo '<td>
    <form method="POST" action="/demo/hello/public/original/edit2/">
        <input type="hidden" name="edit_id2" value="' . $id2 . '">
        <input type="submit" value="編集">
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
