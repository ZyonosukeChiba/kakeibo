<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>収支グラフ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
  </head>
  <body>


  <p>月ごとの収支を見る</p>
<form method="POST" action="/demo/hello/public/original/year/">
    <input type="text" name="year" id="year" >
    <input type="submit" value="送信">
</form>

  <?php



$email = Session::get('email');



  //支出データ
  $data = array();
  $year = Session::get('year');
  echo $year;
  for ($i = 1; $i <= 12; $i++) {
      $month = sprintf("%02d", $i); // 2桁の0埋めされた月の形式に変換
     
  
      $result = DB::select('id', 'date', 'title', 'price')
          ->from('kaeibo')
          ->where('email', '=', $email)
          ->and_where(DB::expr("DATE_FORMAT(date, '%Y-%m')"), '=', $year .'-' . $month)
          ->execute()
          ->as_array();
  
      $out = 0;
      $data[$i] = array(); // 動的なインデックスを持つ配列を初期化
  
      foreach ($result as $row) {
          $id = $row['id'];
          $out += $row['price'];
  
          // テーブル行のデータを配列に追加する
          $data[$i][] = $row['price'];
      }
      
$total[$i] = array_sum($data[$i]);
  }
  
  $jsonData = json_encode($total);

//収入データ
$data2 = array();

for ($i = 1; $i <= 12; $i++) {
    $month = sprintf("%02d", $i); // 2桁の0埋めされた月の形式に変換
   

    $result = DB::select('id', 'date2', 'income_name', 'price2')
        ->from('income')
        ->where('email', '=', $email)
        ->and_where(DB::expr("DATE_FORMAT(date2, '%Y-%m')"), '=', $year .'-' . $month)
        ->execute()
        ->as_array();

    $in = 0;//out直すかも？
    $data2[$i] = array(); // 動的なインデックスを持つ配列を初期化

    foreach ($result as $row) {
        $id = $row['id'];
        $in += $row['price2'];

        // テーブル行のデータを配列に追加する
        $data2[$i][] = $row['price2'];
    }
    
$total2[$i] = array_sum($data2[$i]);
}

$jsonData2 = json_encode($total2);






?>

<script>
  var data = <?php echo $jsonData; ?>;
  var data2 = <?php echo $jsonData2; ?>;
  console.log(data);
  console.log(data2);

    var barChartData = {
  labels: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
  datasets: [
    { 
      label: '収入',
      data: [data2[1],data2[2],data2[3],data2[4],data2[5],data2[6],data2[7],data2[8],data2[9],data2[10],data2[11],data2[12]],
      borderColor : "rgba(154,164,235,0.8)",
      backgroundColor : "rgba(154,164,235,0.5)",
    },
    { 
      label: '出費',
      data: [data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[8],data[9],data[10],data[11],data[12]],
      borderColor : "rgba(54,164,235,0.8)",
      backgroundColor : "rgba(54,164,235,0.5)",
    },
  ], 
}; 

var complexChartOption = {
  responsive: true,
};

window.onload = function() {
 var ctx = document.getElementById("canvas").getContext("2d");
  window.myBar = new Chart(ctx, {
    type: 'bar',
    data: barChartData,
    options: complexChartOption
  });
};
</script>

    <canvas id="canvas" width="300px" height="300px"></canvas>
 </body>
</html> 