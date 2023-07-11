
import React, { useState } from 'react';
import "./css/App.css"

function App() {

   const signinform = ()=>{
       
   }

   return (
    <div>
      <div className="formContainer">
        <form action="demo/hello/public/original/form3/" method="POST">
          <h1>ログインフォーム</h1>
          <hr/>
          <div className="uiForm">
            <div className="formField">
              <label>メールアドレス</label>
              <input type="text" name="email1" id="email1" required></input>
            </div>
            <div className="formField">
              <label>パスワード</label>
              <input type="password" name="password1" id="password1" required></input>
            </div>
            <button className="submitButton">ログイン</button>  
          </div>
        </form>

      </div>
      
    </div>
  );
  



    } export default App;
  