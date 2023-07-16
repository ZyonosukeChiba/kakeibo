<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script> 
  

     <?php echo Asset::css('styles.css'); ?>
    <title>家計簿アプリ</title>
    
</head>
<body>
<?php

$result = DB::select('id', 'date', 'title', 'price')
    ->from('kaeibo')
    ->where('id', '=', $edit_id)
    ->execute()
    ->as_array();
    $date = $result[0]['date'];
    $title = $result[0]['title'];
    $price = $result[0]['price'];
   
?>
<div class="formContainer">
    <h2>入力内容の変更</h2>
    <form method="POST" action="/demo/hello/public/original/kakeibo_form_update/">
        <div class="uiForm">
            <div class="formField">
                <label for="date">日付:</label>
                <input type="date" name="date" id="date" value="<?php echo $date?>"><br>
            </div>
        </div>
        <div class="formField">
            <label for="title">分類:</label>
          <input type="text" name="title"  value="<?php echo $title ?>" list="payment-select" placeholder="テキスト入力もしくはダブルクリック" autocomplete="off"><br>
            <datalist id="payment-select">
                <option value="">please choose an option</option>
                <option value="食費">食費</option>
                <option value="光熱費">光熱費</option>
                <option value="交際費">交際費</option>
                <option value="クレジットカード">クレジットカード</option>
            </datalist>
        </div>
        <div class="formField">
            <label for="price">金額:</label>
            <input type="text" id="price" name="price" value="<?php echo $price ?>">円
        </div>
        <input type="hidden"  name="editid" value="<?php echo $edit_id ?>">
        <input type="submit" value="送信">
    </form>
</div>

</body>
</html>
