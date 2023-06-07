<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿アプリ</title>
</head>
<body>
    <h1>家計簿アプリ</h1>
    <p>残高  円</p>

    <form method="POST" action="/demo/hello/public/original/kform/">
        支払い：<input type="text" name="a" list="payment-select" placeholder="テキスト入力もしくはダブルクリック" autocomplete="off">
    <datalist name="payment" id="payment-select">
        <option value="">please choose an option</option>
        <option value="food">食費</option>
        <option value="utility">光熱費</option>
        <option value="entertaiment">交際費</option>
        <option value="card">クレジットカード</option>
    </datalist>
</form>


    <label>金額 :<input type="text" id="pay">円</label>
    <p id="aa"></p>

<script>
    function inputChange(event){
       aa.innerText=pay.value+'円'
    }
    
     let pay=document.getElementById('pay');
     pay.addEventListener('change',inputChange);
     let aa=document.getElementById('aa')
</script>

<p> 2023年6月2日 
</p>

</body>
</html>