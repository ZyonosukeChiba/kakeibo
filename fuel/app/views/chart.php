

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
  <?php echo Asset::css('chart.css'); ?>
  <title>グラフページ</title>
</head>
<body>

<form method="POST" action="/demo/hello/public/original/year/">
   

  <select name="year">
    <option value="2023">-</option>
    <option value="2023">2023</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
    <option value="2027">2027</option>
    <option value="2028">2028</option>
    <option value="2029">2029</option>
    <option value="2030">2030</option>
  </select>年
   <input type="submit" value="送信">
</form>
  <span data-bind="text: myVariable"></span>

<script>
     
 fetch('http://localhost:8880/demo/hello/public/original/display_kakeibo_chart_data')
   
  .then(response => response.json())
  .then(data => {
    console.log(data);
  
    var barChartData = {
    
      datasets: [
        { 
          label: '収入',
          data: data,
          borderColor : "rgba(154,164,235,0.8)",
          backgroundColor : "rgba(154,164,235,0.5)",
        },
      ], 
    }; 
  
    var complexChartOption = {
      responsive: true,
    };
  
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myBar = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: complexChartOption
    });
  })
  .catch(error => {
    console.error('データの取得に失敗しました:', error);
  });

fetch('http://localhost:8880/demo/hello/public/original/display_income_chart_data')
  .then(response => response.json())
  .then(data2 => {
    console.log(data2);
    // データを使って何らかの処理を行う
    var chart = window.myBar;
    chart.data.datasets.push({
      label: '出費',
      data: data2,
      borderColor: "rgba(54,164,235,0.8)",
      backgroundColor: "rgba(54,164,235,0.5)"
    });
    chart.update();
  })
  .catch(error => {
    console.error('データの取得に失敗しました:', error);
  });

      var date;
 fetch('http://localhost:8880/demo/hello/public/original/display_year/')
  .then(response => response.json())
  .then(data => {
    date = data;
    console.log(date);

    function MyViewModel() {
      var self = this;
      self.myVariable = ko.observable(date+'年の収支グラフ');
    }

  // ViewModelをバインディング
    var viewModel = new MyViewModel();
    ko.applyBindings(viewModel);
  })
  .catch(error => {
    console.error('データの取得に失敗しました:', error);
  });

  </script>
  <canvas id="canvas" ></canvas>
</body>
</html>

