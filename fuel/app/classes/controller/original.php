<?php

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */

require_once ('model/Model.php');

use \Model\Welcome;
class Controller_Original extends Controller
{
/**
 * The basic welcome message
 *
 * @access  public
 * @return  Response
 */
/**
 * A typical "Hello, Bob!" type example.  This uses a Presenter to
 * show how to use them.
 *
 * @access  public
 * @return  Response
 */

 public function before()
{  try {

if ($this->request->action === 'kform') {
	$this->before_specific_method();
}else if ($this->request->action === 'income_form') {
	$this->before_specific_method();
}}catch (Exception $e) {
	// エラーが発生した場合の処理
	$error_code = $e->getCode(); 
	// リダイレクトを行う
	Response::redirect('original/form3/', $error_code); // リダイレクト先のURLを指定

}
}
 private function before_specific_method()
{
if(!Auth::check()=='ture'){
	Response::redirect('original/form3/');
}
}


//初期画面表示
 public function action_new(){
return View::forge('signin');

}
 public function action_chart(){
return View::forge('chart');
}
 public function action_chart2(){
return View::forge('chart2');
}
 public function action_chart3(){
return View::forge('chart3');
}
 public function action_c1(){
return View::forge('chart');
}
 public function action_view(){
return View::forge('viewtest');
}


 public function action_q(){
  return View::forge('year');
}



 public function action_signin(){
  return View::forge('signin');
}

//emailをセッションに保存
 public function action_email()
{
  \Session::instance()->start();
   $email = Input::post('email'); // フォームからemailの値を取得
  \Session::set('email', $email); 

   return View::forge('viewtest');
}		


 public function action_kform()
{

	if(Input::post()){
	$email = Session::get('email');
	$val=Validation::forge();
	$val->add_field('date','日付','required');
	$val->add_field('title','分類','required');
	$val->add_field('price','金額','required');
	if($val->run()){
		$date = Input::post('date');
		$title = Input::post('title');
		$price = Input::post('price');
		

		$kform = new Welcome();
		$kform -> kform($email,$date,$title,$price);
		
		

	}
	else{
		foreach($val->error()as $key=>$value){
			echo $value->get_message();
		}exit;
	}
	}
	return View::forge('viewtest');

}



public function action_income_form()
{

if(Input::post()){
$email=Session::get('email');
$val=Validation::forge();
$val->add_field('date2','日付','required');
$val->add_field('income_name','分類','required');
$val->add_field('price2','金額','required');
if($val->run()){
	$date2 = Input::post('date2');
	$income_name = Input::post('income_name');
	$price2 = Input::post('price2');
	
	$income = new Welcome();
	$income ->income($email,$date2,$income_name,$price2);
	
	

		}else{
	foreach($val->error()as $key=>$value){
		echo $value->get_message();
	}
	exit;

	}
	}

return View::forge('viewtest');

}    


public function action_kform2()
	{
		
		if(Input::post()){
		$email = Session::get('email');
		$val=Validation::forge();
		$val->add_field('date','日付','required');
		$val->add_field('title','分類','required');
		$val->add_field('price','金額','required');
		if($val->run()){
            $date = Input::post('date');
            $title = Input::post('title');
            $price = Input::post('price');
			$edit_id=Input::post('editid');

			$kform2 = new Welcome();
			$kform2 -> kform2($email,$date,$title,$price,$edit_id);



        }
		else{
			foreach($val->error()as $key=>$value){

			}
			exit;

			}
			} 
			 return View::forge('viewtest');
		}

 public function action_income_form2()
	{

		if(Input::post()){
        $email=Session::get('email');
		$val=Validation::forge();
		$val->add_field('date2','日付','required');
		$val->add_field('income_name','分類','required');
		$val->add_field('price2','金額','required');
		if($val->run()){
            $date2 = Input::post('date2');
            $income_name = Input::post('income_name');
            $price2 = Input::post('price2');
			$edit_id2=Input::post('editid2');
            $income2 = new Welcome();
            $income2 ->income2($email,$date2,$income_name,$price2,$edit_id2);

			

				}else{
			foreach($val->error()as $key=>$value){
				echo $value->get_message();
			}
			exit;

			}
			} return View::forge('viewtest');
		}





// public function action_auth3()
// {
// if (Input::post()) {
// $validation = \Validation::forge();
// $validation->add('email', 'メールアドレス')
// ->add_rule('is_unique_email');
// if($validation->run()){
// 	if (Input::post()) {
// \Session::instance()->start();
// $email = Input::post('email'); // フォームからemailの値を取得
// \Session::set('email', $email); 
// $username = Input::post('email');
// $password = Input::post('password');
// $created = Auth::create_user($username, $password, $email, 1);

// if ($created) {
// 	Auth::login($email,$password);
// 	return View::forge('viewtest');
// } else {
// 	// 登録失敗時の処理
// 	echo 'ユーザーの作成に失敗しました';
// 	return View::forge('signin');
// }
// }
// }} else {
// // フォームが送信されていない場合の処理
// echo '正しいフォームを入力してください';
// return View::forge('signin');
// }

// }

public function action_auth3()
{
	$message = \Session::get_flash('exist_email');
if ($message) {
    echo $message;
	}

if (Input::post()) {
            \Session::instance()->start();
            $email = Input::post('email');
            \Session::set('email', $email);
            $username = Input::post('email');
            $password = Input::post('password');
            $created = Auth::create_user($username, $password, $email, 1);

            if ($created) {
                Auth::login($email, $password);
                return View::forge('viewtest');
            } else {
                // 登録失敗時の処理
                echo 'ユーザーの作成に失敗しました';
                return View::forge('signin');
			}
        } else {
        // フォームが送信されていない場合の処理
      
        return View::forge('signin');
    }
}














public function action_month()
{
\Session::instance()->start();
$month = Input::post('month'); 
\Session::set('month', $month); 

return View::forge('viewtest');
}
public function action_year()
{
\Session::instance()->start();
$year = Input::post('year'); 
\Session::set('year', $year); 

return View::forge('chart');
}








public function action_form3()
{
\Session::instance()->start();
	$email = Input::post('email1');// フォームからemailの値を取得
	\Session::set('email', $email); 
	$password=Input::post('password1');
	if(input::post()){
	if(Auth::login($email,$password)){
		return View::forge('viewtest');}
	else {
		echo 'ログインできません';
		return View::forge('login2');
	}}


else{echo 'フォームを入力してください';}

return  View::forge('login2');
echo 'ポストされていません';
}





public function action_logout(){
Auth::logout();

if(Auth::check()=='ture'){
echo 'ログアウト失敗';

}
else{
echo 'ログアウトしました。';
Response::redirect('original/form3/');

}
}


public function action_signout()
{	if(Input::post()){
$email=Input::POST('email');

DB::delete('users')
	->where('email', '=', $email)
	->execute();

	Response::redirect('original/form3/');}
}






public function action_delete()
{
if(Input::post()){
$deleteId = $_POST['delete_id'];
DB::delete('kaeibo')
	->where('id', '=', $deleteId)
	->execute();

return View::forge('viewtest');}
else{
	return View::forge('viewtest');}
}
 
public function action_delete2()
{
if(Input::post()){
$deleteId2 = $_POST['delete_id2'];
DB::delete('income')
	->where('id', '=', $deleteId2)
	->execute();

	return View::forge('viewtest');}
	else{
		return View::forge('viewtest');
	}
}

public function action_edit()
{if(Input::post()){
$editid = $_POST['edit_id'];
// ビューを作成
$view = View::forge('edit');

// 値をビューに設定
$view->set('edit_id', $editid);


// ビューをレンダリングして返す
return $view;

}else{
return View::forge('viewtest');
}}


public function action_edit2()
{
if(Input::post()){
	$editid2 = $_POST['edit_id2'];
	// ビューを作成
	$view = View::forge('edit2');

	// 値をビューに設定
	$view->set('edit_id2', $editid2);
	

	// ビューをレンダリングして返す
	return $view;
}
}





/**
 * The 404 action for the application.
 *
 * @access  public
 * @return  Response
 */
public function action_404()
{
return Response::forge(Presenter::forge('welcome/404'), 404);
}


}

