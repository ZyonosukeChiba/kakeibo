<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.2/knockout-min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>チャット</title>
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
   .clname{

    margin-bottom:20px;

   }

    </style>
</head>

<body>
    <?php
\Session::instance()->start();
$email = Session::get('email');
?>

<?php echo View::forge('header'); ?>





    <div id="commentContainer"></div>


    <div id="commentArea"></div>

    <button id="myButton">コメントする</button>

    <button id="myWari">割り勘する</button>
    

    <script>
    const commentArea = document.getElementById('commentArea'); 
    const button = document.getElementById('myButton');
    const button2 = document.getElementById('myWari');
    $.ajax({
        type: "GET",
        url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/commentv2"); ?>',
        dataType: "json",
        success: function(response) {
            if (response.success) {
            
                response.tasks.forEach(function(task) {

                    // console.log(task.email)


                    
                    const commentDiv = document.createElement('div');
                    commentDiv.className = "clname";

                    commentDiv.innerHTML = task.email + "<br>" + task.comment;



                    commentDiv.classList.add('comment');

                    commentArea.appendChild(commentDiv);



                });
            } else {
                Swal.fire("コメントの取得に失敗しました:", response.error_message);
            }
        },
        error: function() {
            Swal.fire("コメントの取得中に通信エラーが発生しました");
        }
    });




    button.addEventListener('click', addcom);

    function addcom() {
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
                    

                      
                      
                        commentDiv.innerHTML = "<?php echo ($email); ?>"+'(New comment)'+"<br>" +result.value ;
                        commentDiv.classList.add('comment');
                       

                       
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
    button2.addEventListener('click', addwari);

    function addwari() {
        Swal.fire({
            title: '割り勘',
            html: `
                <label>もの</label>
                <input id="swal-input3" type="text" class="swal2-input" placeholder="買ったものを入力してください">
                <br>
                <label>値段</label>
                <input id="swal-input1" type="number" class="swal2-input" placeholder="値段を入力してください">
                <br>
                <label>人数を入力</label>
                <input id="swal-input2" type="number" class="swal2-input" placeholder="人数を入力してください">
            `,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "計算",
            preConfirm: () => {
                const num1 = parseFloat(document.getElementById('swal-input1').value);
                const num2 = parseFloat(document.getElementById('swal-input2').value);
                const a = document.getElementById('swal-input3').value;

                if (!num2) { // 0での除算を防ぐ
                Swal.showValidationMessage("0で除算することはできません");
                return;
                }

            
            $sum =   num1 / num2;
            return (a+':'+"1人"+$sum+"円です");
  }
}).then((result) => {
        if (result.value) {
            Swal.fire({
                title: `結果: ${result.value}`,
                confirmButtonText: "投稿",
                showCancelButton: true,
                cancelButtonText: "キャンセル"
            }).then((postResult) => {
                if (postResult.isConfirmed) {
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

                        commentDiv.textContent =result.value+ " 　　　";
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
    });
}






// .then((result) => {
//   if (result.value) {
//     Swal.fire(`結果: ${result.value}`);
//   }
// })
// .then(function(result) {
//             if (result.isConfirmed && result.value) {
//                 // Ajaxを使用してコメントをサーバーに送信
//                 $.ajax({
//                     type: "POST",
//                     url: '<?php echo "/" . \Uri::segment_replace("demo/hello/public/1/commentv"); ?>',
//                     dataType: "json",
//                     data: {
//                         comment: result.value,

//                     }
//                 }).done(function(response) {
//                     if (response.success) {
//                         const commentDiv = document.createElement('div');
//                         const userDiv = document.createElement('span');

//                         commentDiv.textContent = result.value + " 　　　";
//                         userDiv.textContent = "<?php echo ($email); ?>" + "(New comment)";

//                         commentDiv.classList.add('comment');
//                         userDiv.classList.add('user');

//                         commentDiv.appendChild(userDiv);
//                         commentArea.appendChild(commentDiv);

//                         Swal.fire("成功", "コメントが追加されました", "success");
//                     } else {
//                         Swal.fire("エラー", "コメントの追加に失敗しました", "error");
//                     }
//                 }).fail(function() {
//                     Swal.fire("エラー", "通信エラーが発生しました", "error");
//                 });
//             }
//         });
//     }
    </script>

</body>

</html>