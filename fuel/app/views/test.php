 <?php
// トークンを記載します
$token = 'Zk8iff8mcojr5W42clSF7sacBfUvFk9kI91JBGm3Ijh';

// リクエストヘッダを作成します
$message = 'LINEからの通知です。';
$query = http_build_query(['message' => $message]);
$header = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $token,
        'Content-Length: ' . strlen($query)
];

$ch = curl_init('https://notify-api.line.me/api/notify');
$options = [
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_POST            => true,
    CURLOPT_HTTPHEADER      => $header,
    CURLOPT_POSTFIELDS      => $query,
    CURLOPT_SSL_VERIFYPEER  => false  // SSLの検証を行わない場合
];

curl_setopt_array($ch, $options);
curl_exec($ch);
curl_close($ch);
?> 