<?php
 $year = Session::get('year');

$email = Session::get('email');

// 支出データ
$data = array();


for ($i = 1; $i <= 12; $i++) {
    $month = sprintf("%02d", $i);

    $result = DB::select('id', 'date', 'title', 'price')
        ->from('kaeibo')
        ->where('email', '=', $email)
        ->and_where(DB::expr("DATE_FORMAT(date, '%Y-%m')"), '=', $year .'-' . $month)
        ->execute()
        ->as_array();

    $total = 0;
    $data[$i] = array();

    foreach ($result as $row) {
        $total += $row['price'];
        $data[$i][] = $row['price'];
    }

    $totalData[$i] = $total;
}


$jsonData = json_encode($totalData);
echo $jsonData;

?>
