<?php
$data = array(
  'name' => 'John Doe',
  'age' => 30,
  'email' => 'john.doe@example.com'
);

header('Content-Type: application/json');
echo json_encode($data);
?>
