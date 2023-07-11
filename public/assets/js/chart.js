fetch('call.php')
.then(response => response.json())
.then(data => {
  console.log(data);
  // 応答のデータを処理する
})
.catch(error => console.error(error));
