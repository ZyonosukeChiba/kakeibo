<?php



// $email = Session::get('email');



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