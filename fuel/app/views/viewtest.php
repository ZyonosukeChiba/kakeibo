<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿アプリ</title>
</head>
<body>




    <h1>家計簿アプリ</h1>
    <p>残高  円</p>
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







<?php
// $result= DB::select('*')->from('kaeibo')->execute()->as_array();
		// echo '<pre>';
		// print_r($result);
?> 
</body>
</html>