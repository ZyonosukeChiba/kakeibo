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
class Controller_Original extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */


	//  if (Input::method() == 'POST') {
	// 	$email = Input::post('email');
	// 	$password = Input::post('password');

	// 	$user = Model_User::forge(array());


	// 	if ($user->login($email, $password)) {
	// 		// ログイン成功の処理を実装する
	// 		echo 'ログイン成功';
	// 	} else {
	// 		// ログイン失敗の処理を実装する
	// 		echo 'ログイン失敗';
	// 		echo $email;
			
	// 	}}
	// else {
	// 	return View::forge('login2');
	
	 

	 public function action_login()
	{
}




	
	
	 
	 







    public function action_yap()
	{
		return View::forge('login2');
	}
    public function action_yap2()
	{
	var_dump(Auth::login('aaa','a'));
	}




	






	public function action_kform()
	{
		if(Input::post()){
			
		$val=Validation::forge();
		$val->add_field('date','日付','required');
		$val->add_field('title','分類','required');
		$val->add_field('price','金額','required');
		if($val->run()){
			$email=Session::get('email');
			DB::insert('kaeibo')->set(array(
				'date'=>Input::post('date'),
				'title'=>Input::post('title'),
				'price'=>Input::post('price'),
			
				'email'=>$email
				))->execute();
				
		}else{
			foreach($val->error()as $key=>$value){
				echo $value->get_message();
			}
exit;

		}
		}
		return View::forge('viewtest');

	}
	public function action_auth(){

	\Session::instance()->start();
    $email = Input::post('email'); // フォームからemailの値を取得
    \Session::set('email', $email); 
	


		if (Input::method() === 'POST') {
		$user = Model_User::forge();
		$user->username = Input::post('username');
		$user->password = Input::post('password');
		$user->email = Input::post('email');
		
		if ($user->save()) {
			// 登録成功時の処理
			return View::forge('viewtest');
		} else {
			// 登録失敗時の処理
			echo 'ユーザーの登録に失敗しました。';
		}
	} else {
		// 登録ページの表示
		return View::forge('signin');
	}


	}


// 	public function action_auth2(){

		
	


// 		if (Input::method() === 'POST') {
// 		$user = Model_User::forge();
// 		// $user->email = Input::post('email');
// 		// $user->password = Input::post('password');
// $email=Input::post('email');
// $password=Input::post('password');


// 		if (Auth::login($email, $password) ){
// 			// 登録成功時の処理
// 			return View::forge('viewtest');
// 		} else {
// 			// 登録失敗時の処理
// 			echo 'ログインできません';
// 		}
// 	} else {
// 		// 登録ページの表示
// 		return View::forge('signin');
// 	}


// 	}



	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
	
		return View::forge('login');
	}


	public function action_insert()
	{
		DB::insert('Friends')->set(array(
			'name1'=>'千葉',
			'name2'=>'じょう',
			'tel'=>'01230192',
			


		))->execute();
	}

	public function action_out()
	{
		$result= DB::select('*')->from('Friends')->execute()->as_array();
		echo '<pre>';
		print_r($result);
	}

	public function action_form2()
	{

		echo Input::post('name1');
		return View::forge('form');

	}




	
	public function action_index(){
		$data=array();
		$data['name']='千葉千葉千葉';
		return Response::forge(View::forge('test',$data));
		
	}

	
	public function action_income_form()
	{
		if(Input::post()){

		$val=Validation::forge();
		$val->add_field('date2','日付','required');
		$val->add_field('income_name','分類','required');
		$val->add_field('price2','金額','required');
		if($val->run()){
			$email=Session::get('email');
			DB::insert('income')->set(array(
				'date2'=>Input::post('date2'),
				'income_name'=>Input::post('income_name'),
				'price2'=>Input::post('price2'),
				'email'=>$email
				))->execute();

		}else{
			foreach($val->error()as $key=>$value){
				echo $value->get_message();
			}
exit;

		}
		}





		return View::forge('viewtest');

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
