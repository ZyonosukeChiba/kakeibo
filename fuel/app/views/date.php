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
     if($email != null) {
         echo $email . 'さんようこそ';

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

<form method="POST" action="/demo/hello/public/original/signout/">
    <input type="hidden" name="email" value="<?php $email = Session::get('email');
    echo htmlspecialchars($email); ?>">
    <button type="submit">退会する</button>
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

            self.tasks = ko.observableArray([]);

            self.addTask = function(id,date, task,done) {
                self.tasks.push({
                    id: id,
                    date: date,
                    task: task,
                    
                });
            };
           

            self.getTasksForDate = function(date) {
                return ko.utils.arrayFilter(self.tasks(), function(task) {
                    return task.date === date;
                });
            };

            self.loadTasksFromServer = function() {
                $.ajax({
                    type: "GET",
                    url: '<?php echo '/'.\Uri::segment_replace('demo/hello/public/1/tasks');?>',
                    dataType: "json"
                }).done(function(response) {
                   
                    if (response.success) {
                        const tasksFromServer = response.tasks;
                        tasksFromServer.forEach(function(task) {
                            let dateR =task.date ;
                            let formattedDate = dateR.replace(/\b0+/g, '');
                            // self.addTask(task.id,formattedDate, task.task);
                            self.addTask(task.id, formattedDate, task.task, task.done === 1);
                          
                            
                        });
                        createCalendar(currentMonth, currentYear);
                       

                    }
                }).fail(function() {
                    Swal.fire("エラー", "タスクの読み込みに失敗しました", "error");
                });
                };
        }
        


           //カレンダーを作る
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
                        taskElement.setAttribute('data-task-id', task.id);
                        taskElement.addEventListener('click', onTaskClick);
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
                url: '<?php echo '/'.\Uri::segment_replace('demo/hello/public/1/add');?>',
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
                url: '<?php echo "/".\Uri::segment_replace("demo/hello/public/1/update"); ?>',
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
                url: '<?php echo "/".\Uri::segment_replace("demo/hello/public/1/done"); ?>',
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
        url: '<?php echo "/".\Uri::segment_replace("demo/hello/public/1/deletetask"); ?>',
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
               
                const nextMonthButton = document.getElementById('nextMonth');
                nextMonthButton.addEventListener('click', goToNextMonth);
                const lastMonthButton = document.getElementById('lastMonth');
                lastMonthButton.addEventListener('click', goToLastMonth);
                });


                

    </script>




</body>

</html>





