<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <title>サインイン</title>
    <script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
</head>

<body>
    <div id="root"></div>




    <script type="text/babel">

        const App = () => {
            const[inputValue,setInputValue]=React.useState("ご質問、ご連絡など")
            return (
                <div>
                   
                    <form action="/demo/hello/public/original/inquiry/" method="POST">
                    <h2>お問合せ</h2>
                    <p>ご要望、ご連絡などお気軽にお問合せください</p>
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


