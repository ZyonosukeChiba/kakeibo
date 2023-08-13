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
        
    </style>
</head>

<body>
    <div id="calendarControls">
        <button id="lastMonth">前の月</button>
        <button id="nextMonth">次の月</button>
    </div>
    <div id="calendar"></div>

    <script>
        function CalendarViewModel() {
            const self = this;

            self.tasks = ko.observableArray([]);

            self.addTask = function(date, task) {
                self.tasks.push({
                    date: date,
                    task: task
                });
            };

            self.getTasksForDate = function(date) {
                return ko.utils.arrayFilter(self.tasks(), function(task) {
                    return task.date === date;
                });
            };
        }

        const viewModel = new CalendarViewModel();
        ko.applyBindings(viewModel);

        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        function goToNextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            createCalendar(currentMonth, currentYear);
        }

        function goToLastMonth() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            createCalendar(currentMonth, currentYear);
        }

        function onTaskClick(event) {
    const taskElement = event.target;
    const currentTaskContent = taskElement.textContent;

    Swal.fire({
    title: 'タスクの操作を選択',
    text: "どの操作を行いますか？",
    icon: "warning",
    showCancelButton: true,
    showCloseButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "編集",
    cancelButtonText: "削除",
    showDenyButton: true,
    denyButtonText: "完了"
}).then(function(result) {
    if (result.isConfirmed)  {
        if (result.isConfirmed) {
    // 編集処理
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
            Swal.showValidationMessage("タスクの内容を入力してください");
            return;
        }

        // タスクをviewModel.tasksから見つけて更新
        const taskDate = taskElement.parentNode.getAttribute('data-date');
        const taskObj = ko.utils.arrayFirst(viewModel.tasks(), function(task) {
            return task.date === taskDate && task.task === currentTaskContent;
        });

        if (taskObj) {
            taskObj.task = result.value;
        }

        taskElement.textContent = result.value;
        Swal.fire("更新完了!", `更新されたタスク: ${result.value}`, "success");
    });
}
}
            // 編集処理
           else if (result.isDenied) {
            // 完了処理
            taskElement.style.textDecoration = 'line-through';
            swal("完了！", "タスクが完了しました", "success");
            
        }else if (result.dismiss === Swal.DismissReason.cancel) {
            // 削除処理
            const taskDate = taskElement.parentNode.getAttribute('data-date');
            viewModel.tasks.remove(function(task) {
                return task.date === taskDate && task.task === currentTaskContent;
            });

            taskElement.remove();
            swal("削除完了!", "タスクが削除されました", "success");
        }
    });
}



            document.querySelectorAll('.task').forEach(task => {
                task.addEventListener('click', onTaskClick);
            });



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

                        const tasksForDate = viewModel.getTasksForDate(`${year}-${month + 1}-${dayCount}`);
                        tasksForDate.forEach(task => {
                            const taskElement = document.createElement('div');
                            taskElement.textContent = task.task;
                            taskElement.classList.add('task');
                            taskElement.addEventListener('click', onTaskClick); // この行を追加
                            cell.appendChild(taskElement);
                        });

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
                    url: '<?php echo Uri::create("1/add"); ?>',
                    dataType: "json",
                    data: {
                        date: selectedDate,
                        task: result.value
                    }
                }).done(function(response) {
                    // サーバからの応答に基づいて処理
                    if (response.success) {
                        Swal.fire("追加完了!", `追加されたタスク: ${result.value}`, "success");
                        viewModel.addTask(selectedDate, result.value);
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


// function onDateClick(event) {
//             const selectedDate = event.target.getAttribute('data-date');
//             if (selectedDate) {
//                 Swal.fire({
//     title: 'タスクを追加します',
//     text: "タスクの内容を入力してください:",
//     input: 'text',
//     inputPlaceholder: "タスクの内容",
//     showCancelButton: true,
//     confirmButtonColor: "#DD6B55",
//     confirmButtonText: "OK"
// }).then(function(result) {
//     if (result.isConfirmed && result.value) {
//         if (result.value === "") {
//             Swal.showValidationMessage("タスクの内容を入力してください");
//             return;
//         }

//         Swal.fire("追加完了!", `追加されたタスク: ${result.value}`, "success");
//         viewModel.addTask(selectedDate, result.value);
//         createCalendar(currentMonth, currentYear);
//     }
// });

//             }
//         }



        document.addEventListener('DOMContentLoaded', function() {
            createCalendar(currentMonth, currentYear);
            const nextMonthButton = document.getElementById('nextMonth');
            nextMonthButton.addEventListener('click', goToNextMonth);

            const lastMonthButton = document.getElementById('lastMonth');
            lastMonthButton.addEventListener('click', goToLastMonth);
        });

    </script>
</body>

</html>





