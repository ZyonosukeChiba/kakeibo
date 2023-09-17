<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Comment System with FuelPHP and Ajax</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 20px;
    }

    button {
        font-size: 20px;
        padding: 10px 20px;
        margin: 5px;
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
        width: 100%;
    }

    .header-buttons button {
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
                <button type="submit">コメント</button>
            </form>

        </div>
    </div>





    <div id="commentContainer"></div>


    <div id="commentArea"></div>

    <button id="myButton">コメントする</button>

    <script>
    const commentArea = document.getElementById('commentArea'); // ← これも必要です
    const button = document.getElementById('myButton');
    $.ajax({
        type: "GET",
        url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/commentv2"); ?>',
        dataType: "json",
        success: function(response) {
            if (response.success) {
                // console.log(response)
                // // 各コメントをDOMに追加する
                response.tasks.forEach(function(task) {

                    console.log(task.email)


                    console.log(task);
                    const commentDiv = document.createElement('div');


                    commentDiv.textContent = task.comment + "　　　　　　" + task.email;


                    commentDiv.classList.add('comment');

                    commentArea.appendChild(commentDiv);



                });
            } else {
                console.error("コメントの取得に失敗しました:", response.error_message);
            }
        },
        error: function() {
            console.error("コメントの取得中に通信エラーが発生しました");
        }
    });




    button.addEventListener('click', getTask);

    function getTask() {
        Swal.fire({
            title: 'コメントを追加',
            text: "コメントの内容を入力してください:",
            input: 'text',
            inputPlaceholder: "コメントの内容",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "追加",
        }).then(function(result) {
            if (result.isConfirmed && result.value) {
                // Ajaxを使用してコメントをサーバーに送信
                $.ajax({
                    type: "POST",
                    url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/commentv"); ?>',
                    dataType: "json",
                    data: {
                        comment: result.value,

                    }
                }).done(function(response) {
                    if (response.success) {
                        const commentDiv = document.createElement('div');
                        const userDiv = document.createElement('span');

                        commentDiv.textContent = result.value + " 　　　";
                        userDiv.textContent = "<?php echo ($email); ?>" + "(New comment)";

                        commentDiv.classList.add('comment');
                        userDiv.classList.add('user');

                        commentDiv.appendChild(userDiv);
                        commentArea.appendChild(commentDiv);

                        Swal.fire("成功", "コメントが追加されました", "success");
                    } else {
                        Swal.fire("エラー", "コメントの追加に失敗しました", "error");
                    }
                }).fail(function() {
                    Swal.fire("エラー", "通信エラーが発生しました", "error");
                });
            }
        });
    }
    </script>

</body>

</html>