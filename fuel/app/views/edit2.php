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
    $result = DB::select('id', 'date2', 'income_name', 'price2')

    ->from('income')
    ->where('id', '=', $edit_id2)
    ->execute()
    ->as_array();
    $date2 = $result[0]['date2'];
    $income_name = $result[0]['income_name'];
    $price2 = $result[0]['price2'];
   

?>


<div class="formContainer">
    <h2>収入</h2>
    <form method="POST" action="/demo/hello/public/original/income_form/">
        <div class="uiForm">
            <div class="formField">
                <label for="date2">日付:</label>
                <input type="date" name="date2" id="date2" value="<?php echo $date2 ?>"><br>
            </div>
        </div>
        <div class="formField">
            <label for="income_name">収入元:</label>
            <input type="text" name="income_name"value="<?php echo $income_name ?>"><br>
        </div>
        <div class="formField">
            <label for="price2">金額:円</label>
            <input type="text" id="price2" name="price2" value="<?php echo $price2 ?>">
        </div>
        <input type="submit" value="送信">
    </form>
</div>