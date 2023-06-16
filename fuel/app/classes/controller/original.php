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
//初期画面表示
public function action_new(){
	return View::forge('login');
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
				}
		else{
			foreach($val->error()as $key=>$value){
				echo $value->get_message();
			}exit;
		}
		}
		return View::forge('viewtest');

	}

	
	

	public function action_auth3(){

		

		if(Input::post()){
			\Session::instance()->start();
			$email = Input::post('email'); // フォームからemailの値を取得
			\Session::set('email', $email); 
			$username=Input::post('username');;
			$password=Input::post('password');;
			$email=Input::post('email');
			Auth::create_user($username,$password,$email,1);
			return View::forge('viewtest');
		}
		else {
			// 登録失敗時の処理
			echo '正しいフォームを入力してください';
		}
		{
			// 登録ページの表示
			return View::forge('signin');
		}
	
	}




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


	

	public function action_month()
	{
		\Session::instance()->start();
		$month = Input::post('month'); // フォームからemailの値を取得
		\Session::set('month', $month); 
		
		return View::forge('viewtest');
	}



	public function action_out()
	{
		$result= DB::select('*')->from('Friends')->execute()->as_array();
		echo '<pre>';
		print_r($result);
	}

	public function action_form2()
	{

	Auth::create_user('aaaa','as','aaaa@gmail.com',1);

	}

	public function action_form3()
	{\Session::instance()->start();
		$email = Input::post('email'); // フォームからemailの値を取得
		\Session::set('email', $email); 
		if(input::post()){
        $password=Input::post('password');;
		$email=Input::post('email');
	Auth::login($email,$password);

	return View::forge('viewtest');
	}else{echo 'フォームを入力してください!';}

	return View::forge('login2');
	}



	public function action_logout(){

		Auth::logout();
		return View::forge('login');
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
