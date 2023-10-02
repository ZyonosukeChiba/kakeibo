<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <title>カレンダー</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 20px;
        }

        #calendarControls {
            margin-bottom: 20px;
        }

        button {
            font-size: 20px;
            padding: 10px 20px;
            margin: 5px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            width: 14.28%;
            text-align: center;
            padding: 20px 0;
            border: 1px solid #ddd;
        }

        td[data-date]:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .task {
            font-size: 14px;
            color:blue;
            background-color:#58b48b9a;
        }

        .task:hover {
            background-color: #3a8b68; /* ホバー時の背景色 */
        }
        .header-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f7f7f7;
    padding: 10px 0;
}

.header-buttons form {
    margin: 0 10px;
    width:100%;
}

.header-buttons button {
    padding: 10px 15px;
    cursor: pointer;
    width:100%;
}



    </style>
</head>

<body>

<?php
\Session::instance()->start();
$email = Session::get('email');
echo $other_email . "さんのカレンダー";
\Session::set('other_email', $other_email);

?>



       <div class="button">
        <div class="header-buttons">



<form method="POST" action="/demo/hello/public/original/kakeibo_form_insert/">
    <button type="submit">家計簿アプリ</button>
</form>
<form method="POST" action="/demo/hello/public/original/view2/">
    <button type="submit">自分のカレンダーに戻る</button>
</form>
<form method="POST" action="/demo/hello/public/original/chat/">
    <button type="submit">チャットルーム</button>
</form>



</div>
    </div>
    <div id="calendarControls">
        <button id="lastMonth">前の月</button>
        <button id="nextMonth">次の月</button>
    </div>
    <div id="calendar"></div>




    <script>

        var fuel_csrf_token = '<?php echo \Security::fetch_token(); ?>';
        const viewModel = new CalendarViewModel();
        ko.applyBindings(viewModel);
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        //knockout.jsでデータとUIの関連を助ける
        function CalendarViewModel() {
            const self = this;
            // タスク情報を保持するためのObservableArray（観測可能な配列）を作成しています。ObservableArrayは、要素が変更されると自動的にUIに反映される配列です。
            self.tasks = ko.observableArray([]);
            // : タスクを追加するための関数です。新しいタスクをself.tasksに追加します。
            self.addTask = function(id,date, task) {
                self.tasks.push({
                    id: id,
                    date: date,
                    task: task,

                });

            };

            // 指定された日付に対応するタスクを取得するための関数です。日付を指定して該当するタスクをフィルタリングして返します。
            self.getTasksForDate = function(date) {
                return ko.utils.arrayFilter(self.tasks(), function(task) {
                    return task.date === date;

                });
            };
                // サーバーからデータを取得
            self.loadTasksFromServer = function() {
                $.ajax({
                    type: "GET",
                    url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/tasks2'); ?>',
                    dataType: "json"
                }).done(function(response) {

                    if (response.success) {
                        const tasksFromServer = response.tasks;
                        tasksFromServer.forEach(function(task) {

                            let dateR =task.date ;
                            let formattedDate = dateR.replace(/\b0+/g, '');
                            self.addTask(task.id,formattedDate, task.task);



                        });
                        createCalendar(currentMonth, currentYear);


                    }
                }).fail(function() {
                    Swal.fire("エラー", "タスクの読み込みに失敗しました", "error");
                });
                };

//price
self.items = ko.observableArray([]);

self.addProce = function(id, date, price) {
    self.items.push({
        id: id,
        date: date,
        price: price
    });
    console.log("Added item:", id, date, price);
};


self.getPricesForDate = function(date) {
    return ko.utils.arrayFilter(self.items(), function(item) {
        return item.date === date;
    });
};

self.loadPriceFromServer = function() {
    $.ajax({
        type: "GET",
        url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/payment2'); ?>',
        dataType: "json"
    }).done(function(response) {
        if (response.success) {
            const priceFromServer = response.result;
            priceFromServer.forEach(function(item) {
                let date3 = item.date;
                let formattedDate3 = date3.replace(/\b0+/g, '');
                self.addProce(item.id, formattedDate3, item.price);


            });
            createCalendar(currentMonth, currentYear);
        }
    }).fail(function() {
        Swal.fire("エラー", "価格情報の読み込みに失敗しました", "error");
    });
};
self.calculateTotalPriceForDate = function(date) {
    const pricesForDate = self.getPricesForDate(date);
    let totalPrice = 0;
    pricesForDate.forEach(price => {
        totalPrice += price.price;
    });
    return totalPrice;
};








        }




        // カレンダーの作成
function createCalendar(month, year) {
    const calendar = document.getElementById('calendar');
    calendar.innerHTML = '';

    const title = document.createElement('h2');
    title.textContent = `${year}年 ${month + 1}月`;
    calendar.appendChild(title);

    const table = document.createElement('table');
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');
    const headerRow = document.createElement('tr');

    const days = ['日', '月', '火', '水', '木', '金', '土'];
    days.forEach(day => {
        const th = document.createElement('th');
        th.textContent = day;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    let dayCount = 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            if (i === 0 && j < new Date(year, month, 1).getDay() || dayCount > daysInMonth) {
                cell.textContent = '';
            } else {
                cell.textContent = dayCount;

                // タスクの追加
                const tasksForDate = viewModel.getTasksForDate(`${year}-${month + 1}-${dayCount}`);
                tasksForDate.forEach(task => {
                    const taskElement = document.createElement('div');
                    taskElement.textContent = task.task;
                    taskElement.classList.add('task');
                    taskElement.setAttribute('data-task-id', task.id);
                    // taskElement.addEventListener('click', onTaskClick);
                    cell.appendChild(taskElement);
                });

                // 価格情報の表示
                const dateStr = `${year}-${month + 1}-${dayCount}`;
                const totalPrice = viewModel.calculateTotalPriceForDate(dateStr);
                const priceElement = document.createElement('div');
                priceElement.textContent = `¥${totalPrice}`; // 価格情報を表示
                if (totalPrice !== 0) {
    priceElement.textContent = `¥${totalPrice}`; // 価格情報を表示
    priceElement.classList.add('price');
} else {
    priceElement.textContent = ''; // 価格情報がない場合は空白にする
}
                cell.appendChild(priceElement);

                cell.setAttribute('data-date', `${year}-${month + 1}-${dayCount}`);
                // cell.addEventListener('click', onDateClick);
                dayCount++;
            }
            row.appendChild(cell);
        }
        tbody.appendChild(row);
    }

    table.appendChild(tbody);
    calendar.appendChild(table);





calendar.appendChild(commentSection);

}





        //次の月
        function goToNextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            createCalendar(currentMonth, currentYear);
        }
        //前の月
        function goToLastMonth() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            createCalendar(currentMonth, currentYear);
        }













            document.addEventListener('DOMContentLoaded', function() {

                viewModel.loadTasksFromServer(); // サーバからタスクを読み込む
                viewModel.loadPriceFromServer(); // サーバから支払いを読み込み
                const nextMonthButton = document.getElementById('nextMonth');
                nextMonthButton.addEventListener('click', goToNextMonth);
                const lastMonthButton = document.getElementById('lastMonth');
                lastMonthButton.addEventListener('click', goToLastMonth);

                });







    </script>


</form>

</body>

</html>





