<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <title>サインイン</title>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
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


<?php echo View::forge('header'); ?>
    <div id="root"></div>




    <script type="text/babel">

        const App = () => {

            return (
                <div>
                   
                    <form action="/demo/hello/public/original/inquiry/" method="POST">
                    <h2>お問合せ</h2>
                    <p>ご要望、ご連絡などお気軽にお問合せください</p>
                    <p>LINEでの連絡をご希望の方はLINEIDを添付してください</p>
                    <input 
                    type="text" name="message" id="message"
                        placeholder="ご要望、ご質問など"
                        // style={{ width: '300px', height: '300px' }}
                    />
                    <button className="submitButton">送信</button>  
                    </form>

            
                </div>
            )
        }

        const container = document.getElementById("root");
        const root = ReactDOM.createRoot(container);
        root.render(<App />);

    </script>



</body>

</html>


