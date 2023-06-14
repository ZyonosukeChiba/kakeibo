<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿アプリ</title>
</head>
<body>




    <h1>家計簿アプリ</h1>
    <form method="POST" action="/demo/hello/public/original/email/">
        メールアドレス:<input type="text" name="email" id="email">
       <input type="submit" value="登録"> 
</form>
<?php 

$email = Session::get('email');
if($email!=null){echo $email.'さんようこそ';}
?>


<h2>支出</h2>
    <form method="POST" action="/demo/hello/public/original/kform/">

        日付:<input type="date" name="date"><br>
        分類:<input type="text" name="title" list="payment-select" placeholder="テキスト入力もしくはダブルクリック" autocomplete="off"><br>
    <datalist name="payment" id="payment-select">
        <option value="">please choose an option</option>
        <option value="food">食費</option>
        <option value="utility">光熱費</option>
        <option value="entertaiment">交際費</option>
        <option value="card">クレジットカード</option>
    </datalist>
    



    <label>金額 :<input type="text" id="price" name="price">円</label>
    <p id="aa"></p>
    <input type="submit" value="送信">
    </form>

<h2>収入</h2>
  <form method="POST" action="/demo/hello/public/original/income_form/">

 日付:<input type="date" name="date2"><br>
 収入元:<input type="text" name="income_name" ><br>
   



    <label>金額 :<input type="text" id="price2" name="price2">円</label>
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

$out=0;

$result = DB::select('id','date', 'title', 'price')
->from('kaeibo')
->where('email', '=', $email)
->and_where(DB::expr("DATE_FORMAT(date, '%Y-%m')"), '=', $month)
->execute()
->as_array();

echo '<pre>';
foreach ($result as $row) {$id=$row['id']; 
    $out +=$row['price'];
echo  $row['date'] . ', ' . $row['title'] . ', ' . $row['price'] . '円'.'   '.
'<form method="POST" action="/demo/hello/public/original/delete/">
<input type="hidden" name="delete_id" value=" '.$id.'" ?>
<input type="submit" value="削除">
</form>'.'<br>';
}
echo $out.'円の出費です';




echo '<h2>収入</h2>';

$in=0;
$result = DB::select('id','date2', 'income_name', 'price2')
->from('income')
->where('email', '=', $email)
->and_where(DB::expr("DATE_FORMAT(date2, '%Y-%m')"), '=', $month)
->execute()
->as_array();
echo '<pre>';

foreach ($result as $row) {
    $id2=$row['id'];
    $in+=$row['price2'];
echo $row['date2'] . ', ' . $row['income_name'] . ', ' . $row['price2'] . '円'.'   '.'<form method="POST" action="/demo/hello/public/original/delete2/">
<input type="hidden" name="delete_id2" value=" '.$id2.'" ?>
<input type="submit" value="削除">
</form>'.'<br>';
}
echo $in.'円の収入です';

echo '<br>';

echo '<h2>収支</h2>';
$all=$in-$out;
echo '合計は'.$all.'円です';


?>




</body>
</html>