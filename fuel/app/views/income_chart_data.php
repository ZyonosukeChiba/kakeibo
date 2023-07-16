<?php
 $year = Session::get('year');

$email = Session::get('email');

// 支出データ

$data2 = array();





for ($i = 1; $i <= 12; $i++) {
  $month = sprintf("%02d", $i); // 2桁の0埋めされた月の形式に変換
 

  $result = DB::select('id', 'date2', 'income_name', 'price2')
      ->from('income')
      ->where('email', '=', $email)
      ->and_where(DB::expr("DATE_FORMAT(date2, '%Y-%m')"), '=', $year .'-' . $month)
      ->execute()
      ->as_array();


      $total2 = 0;
      $data2[$i] = array();
  
      foreach ($result as $row) {
          $total2 += $row['price2'];
          $data2[$i][] = $row['price2'];
      }
  
      $totalData2[$i] = $total2;

}


$jsonData2 = json_encode($totalData2);
echo $jsonData2;
?>
