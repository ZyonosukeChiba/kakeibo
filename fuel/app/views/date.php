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
        color: blue;
        background-color: #58b48b9a;
    }

    .task:hover {
        background-color: #3a8b68;
        /* ホバー時の背景色 */
    }

    .price {
        color: red;
    }

    .income {
        color: blue;
    }

    .header-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f7f7f7;
        padding: 10px 0;
    }

    .header-buttons2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f7f7f7;
        padding: 10px 0;
    }

    .header-buttons form {
        margin: 0 10px;
        width: 100%;
    }

    .header-buttons button {
        padding: 10px 15px;
        cursor: pointer;
        width: 100%;
    }

    .header-buttons2 form {
        margin: 0 10px;
        width: 100%;
    }

    .header-buttons2 button {
        padding: 10px 15px;
        cursor: pointer;
        width: 100%;
    }
    </style>
</head>

<body>
    <?php
\Session::instance()->start();
$email = Session::get('email');
if ($email != null) {
    echo $email . 'さんようこそ';
} else {
    Auth::logout();
}
?>




    <div class="button">
        <div class="header-buttons">

            <form method="POST" action="/demo/hello/public/original/display_chart/">
                <button type="submit">グラフを見る</button>
            </form>

            <form method="POST" action="/demo/hello/public/original/kakeibo_form_insert/">
                <button type="submit">家計簿アプリ</button>
            </form>

            <form method="POST" action="/demo/hello/public/original/logout/">
                <button type="submit">ログアウト</button>
            </form>



        </div>
    </div>

    <div class="button">
        <div class="header-buttons2">


            <button id="createGroup">グループを作る</button>

            <form method="post" action="/demo/hello/public/original/view3/">
                <button type="submit">他の人のカレンダーを見る</button>
            </form>

            <form method="POST" action="/demo/hello/public/original/chat/">
                <button type="submit">コメント</button>
            </form>
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
            self.addTask = function(id, date, task) {
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
                    url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/tasks'); ?>',
                    dataType: "json"
                }).done(function(response) {

                    if (response.success) {
                        const tasksFromServer = response.tasks;
                        tasksFromServer.forEach(function(task) {

                            let dateR = task.date;
                            let formattedDate = dateR.replace(/\b0+/g, '');
                            self.addTask(task.id, formattedDate, task.task);



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
                // console.log("Added item:", id, date, price);
            };


            self.getPricesForDate = function(date) {
                return ko.utils.arrayFilter(self.items(), function(item) {
                    return item.date === date;
                });
            };

            self.loadPriceFromServer = function() {
                $.ajax({
                    type: "GET",
                    url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/payment'); ?>',
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
                console.log(totalPrice);
                return totalPrice;
            };


            //収入
            self.incomes = ko.observableArray([]);
            self.addIncome = function(id, date, price) {
                self.incomes.push({
                    id: id,
                    date: date,
                    price: price // ← price2からpriceに変更
                });
                console.log("Added income:", id, date, price);
            };
            self.getIncomesForDate = function(date) {
                return ko.utils.arrayFilter(self.incomes(), function(income) {
                    return income.date === date;
                });
            };
            self.loadIncomesFromServer = function() {
                $.ajax({
                    type: "GET",
                    url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/incomes'); ?>',
                    dataType: "json"
                }).done(function(response) {
                    if (response.success) {
                        console.log(response);

                        const incomesFromServer = response.result; // ← incomesからresultに変更

                        incomesFromServer.forEach(function(income) {
                            let dateR = income.date2;
                            let formattedDate = dateR.replace(/\b0+/g, '');
                            self.addIncome(income.id, formattedDate, income.price2);
                            // console.log(income.price2);
                        });

                        createCalendar(currentMonth, currentYear);
                    }
                }).fail(function() {
                    Swal.fire("エラー", "収入情報の読み込みに失敗しました", "error");
                });
            };
            self.calculateTotalIncomeForDate = function(date) {
                const incomesForDate = self.getIncomesForDate(date);
                let totalIncome = 0;
                incomesForDate.forEach(income => {
                    totalIncome += parseFloat(income.price);

                });
                // console.log(totalIncome);
                return totalIncome;
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
                            taskElement.addEventListener('click', onTaskClick);
                            cell.appendChild(taskElement);
                        });

                        // 価格情報の表示
                        const dateStr = `${year}-${month + 1}-${dayCount}`;
                        const totalPrice = viewModel.calculateTotalPriceForDate(dateStr);
                        const totalIncome = viewModel.calculateTotalIncomeForDate(dateStr); // 合計収入を取得

                        const priceElement = document.createElement('div');
                        if (totalPrice !== 0) {
                            priceElement.textContent = `¥${totalPrice}`; // 価格情報を表示
                            priceElement.classList.add('price');
                        } else {
                            priceElement.textContent = ''; // 価格情報がない場合は空白にする
                        }

                        const incomeElement = document.createElement('div'); // 収入情報を表示する要素を作成
                        if (totalIncome !== 0) {
                            console.log(totalIncome);
                            incomeElement.textContent = `¥${totalIncome}`; // 収入情報を表示
                            incomeElement.classList.add('income');
                        } else {
                            incomeElement.textContent = ''; // 収入情報がない場合は空白にする
                        }

                        cell.appendChild(priceElement);
                        cell.appendChild(incomeElement); // セルに収入情報を追加

                        cell.setAttribute('data-date', `${year}-${month + 1}-${dayCount}`);
                        cell.addEventListener('click', onDateClick);
                        dayCount++;
                    }
                    row.appendChild(cell);
                }
                tbody.appendChild(row);
            }

            table.appendChild(tbody);
            calendar.appendChild(table);




        }








        //タスクの追加
        function onDateClick(event) {
            const selectedDate = event.target.getAttribute('data-date');

            if (selectedDate) {
                Swal.fire({
                    title: 'タスクを追加します',
                    text: "タスクの内容を入力してください:",
                    input: 'text',
                    inputPlaceholder: "タスクの内容",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK"
                }).then(function(result) {
                    if (result.isConfirmed && result.value) {
                        if (result.value === "") {
                            Swal.showValidationMessage("タスクの内容を入力してください");
                            return;
                        }

                        // タスクと日付をサーバに送信
                        $.ajax({
                            type: "POST",
                            url: '<?php echo '/' . \Uri::segment_replace('demo/hello/public/1/add'); ?>',
                            dataType: "json",
                            data: {
                                date: selectedDate,
                                task: result.value
                            }
                        }).done(function(response) {
                            // サーバからの応答に基づいて処理
                            if (response.success) {
                                Swal.fire("追加完了!", `追加されたタスク: ${result.value}`, "success");
                                viewModel.addTask(response.id, selectedDate, result.value);
                                createCalendar(currentMonth, currentYear);

                            } else {
                                Swal.fire("エラー", "タスクの追加に失敗しました", "error");
                            }
                        }).fail(function() {
                            Swal.fire("エラー", "通信エラーが発生しました", "error");
                        });
                    }
                });
            }
        }

        let cyear;
        let cmonth;


        //次の月
        function goToNextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            createCalendar(currentMonth, currentYear);
            cyear = currentYear;
            cmonth = currentMonth;


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
            cyear = currentYear;
            cmonth = currentMonth;

        }


        function createGroup() {
            Swal.fire({
                title: 'グループを作成',
                text: "グループ名を入力してくだいさい:",
                input: 'text',
                inputPlaceholder: "グループ名",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "OK"
            }).then(function(result) {
                if (result.isConfirmed && result.value) {
                    if (result.value === "") {
                        Swal.showValidationMessage("グループ名を入力してくだいさい");
                        return;
                    }

                    $.ajax({
                        type: "PUT",
                        url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/createGroup"); ?>',
                        dataType: "json",
                        data: {
                            group: result.value
                        }
                    }).done(function(response) {
                        // サーバからの応答に基づいて処理
                        if (response.success) {
                            Swal.fire("作成完了!", `グループ名: ${result.value}`, "success");
                        } else {
                            Swal.fire("エラー", "グループの作成に失敗しました", "error");
                        }
                    }).fail(function() {
                        Swal.fire("エラー", "通信エラーが発生しました", "error");
                    });
                }
            });
        }










        // タスクの操作
        function onTaskClick(event) {

            const taskElement = event.target;
            const currentTaskContent = taskElement.textContent;
            const taskId = taskElement.getAttribute('data-task-id');

            // swalで操作の選択
            Swal.fire({
                title: 'タスクの操作を選択',
                text: "どの操作を行いますか？",
                // icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "編集",
                cancelButtonText: "削除",
                // showDenyButton: true,
                // denyButtonText: "完了"
            }).then(function(result) {
                if (result.isConfirmed) {
                    // 編集処理
                    editTask();
                } else if (result.isDenied) {
                    // 完了処理
                    completeTask();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // 削除処理
                    deleteTask();
                }
            });

            function editTask() {
                Swal.fire({
                    title: 'タスクを編集します',
                    text: "新しいタスクの内容を入力してください:",
                    input: 'text',
                    inputValue: currentTaskContent,
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "更新",
                    closeOnConfirm: false
                }).then(function(result) {
                    if (!result.isConfirmed) return;

                    if (result.value === "") {
                        Swal.fire({
                            icon: 'error',
                            title: 'エラー',
                            text: 'タスクの内容を入力してください'
                        });
                        return;
                    }

                    const taskDate = taskElement.parentNode.getAttribute('data-date');
                    const taskObj = ko.utils.arrayFirst(viewModel.tasks(), function(task) {
                        return task.date === taskDate && task.task === currentTaskContent;
                    });

                    if (taskObj) {
                        $.ajax({
                            type: 'PUT',
                            url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/update"); ?>',
                            dataType: "json",
                            data: {
                                id: taskId,
                                newTask: result.value
                            },
                            success: function(response) {
                                taskObj.task = result.value;
                                taskElement.textContent = result.value;
                                Swal.fire("更新完了!", `更新されたタスク: ${result.value}`, "success");
                            },
                            error: function(error) {
                                Swal.fire("更新失敗", "タスクの更新に失敗しました", "error");
                            }
                        });
                    }
                });
            }

            function completeTask() {
                taskElement.style.textDecoration = 'line-through';
                // Swal.fire("完了！", "タスクが完了しました", "success");
                {
                    $.ajax({
                        type: 'PUT',
                        url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/done"); ?>',
                        dataType: "json",
                        data: {
                            id: taskId,

                        },
                        success: function(response) {
                            Swal.fire("完了!", "タスクが完了しました", "success");
                        },
                        error: function(error) {
                            Swal.fire("更新失敗", "更新に失敗しました", "error");
                        }
                    });
                }
            }

            function deleteTask() {
                const taskDate = taskElement.parentNode.getAttribute('data-date');

                viewModel.tasks.remove(function(task) {
                    return task.date === taskDate && task.task === currentTaskContent;
                });

                taskElement.remove();

                $.ajax({
                    type: 'DELETE',
                    url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/deletetask"); ?>',
                    dataType: "json",
                    data: {
                        id: taskId
                    },
                    success: function(response) {
                        Swal.fire("削除完了!", "タスクが削除されました", "success");
                    },
                    error: function(error) {
                        Swal.fire("削除失敗", "タスクの削除に失敗しました", "error");
                    }
                });
            }
        }


        // イベントリスナーを設定
        document.querySelectorAll('.task').forEach(task => {
            task.addEventListener('click', onTaskClick);
        });




        document.addEventListener('DOMContentLoaded', function() {
            viewModel.loadTasksFromServer(); // サーバからタスクを読み込む
            viewModel.loadPriceFromServer(); // サーバから支払いを読み込み
            viewModel.loadIncomesFromServer(); // サーバから支払いを読み込み
            const nextMonthButton = document.getElementById('nextMonth');
            nextMonthButton.addEventListener('click', goToNextMonth);
            const lastMonthButton = document.getElementById('lastMonth');
            lastMonthButton.addEventListener('click', goToLastMonth);
            const createGroupButton = document.getElementById('createGroup');
            createGroupButton.addEventListener('click', createGroup);
            const signoutButton = document.getElementById('signoutButton');

            signoutButton.addEventListener('click', function(event) {
                const isConfirmed = confirm('本当に退会しますか？'); // アラートで確認メッセージを表示
                if (!isConfirmed) {
                    event.preventDefault(); // ユーザーがキャンセルを選択した場合、フォームの送信を停止
                }
            });
        })
        </script>


        <p style="font-size:10px; margin-top:3px;">赤:支出、青:収入</p>
        <form method="POST" action="/demo/hello/public/original/signout/">
            <input type="hidden" name="email" value="<?php $email = Session::get('email');
echo htmlspecialchars($email);?>">
            <button type="submit" id="signoutButton" style="width:200px; margin-top: 100px;">退会する</button>
        </form>


</body>

</html>