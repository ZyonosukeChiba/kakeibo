
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
 
    <?php echo Asset::css('header.css'); ?>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

</head>

<body>
    <div id="root2"></div>




    <script type="text/babel">

        const App = () => {
            return (
                <div>
           
            <div class="button">
     <div class="header-buttons">

     <form method="POST" action="/demo/hello/public/original/kakeibo_form_insert/">
             <button type="submit">家計簿</button>
         </form>
      

         <form method="POST" action="/demo/hello/public/original/view2/">
             <button type="submit">Myカレンダー</button>
         </form>


         <form method="POST" action="/demo/hello/public/original/chat/">
                <button type="submit">チャットルーム</button>
            </form>

         <form method="POST" action="/demo/hello/public/original/logout/">
             <button type="submit">ログアウト</button>
         </form>
        
         

          </div>
 </div>
 </div>
            )
        }

        const container = document.getElementById("root2");
        const root = ReactDOM.createRoot(container);
        root.render(<App />);

    </script>



</body>

</html>


