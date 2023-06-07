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

	





	public function action_viewtest2()
	{
    
        $data=array();
      $data['members']=[
        array('name'=>'山田','age'=>24),
        array('name'=>'人','age'=>99),
        array('name'=>'犬','age'=>31),
        array('name'=>'さる','age'=>241),
        array('name'=>'猫','age'=>2),

      ];
        return View::forge('content',$data);
	}

    public function action_yap()
	{
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
			
			DB::insert('kaeibo')->set(array(
				'date'=>Input::post('date'),
				'title'=>Input::post('title'),
				'price'=>Input::post('price')

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
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
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




	public function action_form()
	{
		if(Input::post()){
			
		$val=Validation::forge();
		$val->add_field('name1','姓','required');
		$val->add_field('name2','名','required');
		$val->add_field('tel','電話番号','required');
		if($val->run()){
			echo '成功';
			DB::insert('Friends')->set(array(
				'name1'=>Input::post('name1'),
				'name2'=>Input::post('name2'),
				'tel'=>Input::post('tel')

				))->execute();
				exit();
		}else{
			foreach($val->error()as $key=>$value){
				echo $value->get_message();
			}
exit;

		}
		}

		



		return View::forge('form');

	}
	public function action_index(){
		$data=array();
		$data['name']='千葉千葉千葉';
		return Response::forge(View::forge('test',$data));
		
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
