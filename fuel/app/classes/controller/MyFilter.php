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


// require_once 'Model.php';

//  use app\Model\newclass;

class Controller_MyFilter extends Controller
{
    public function action_index()
	{
		// モデルから文字列を受け取ってvar_dumpで無理矢理画面に表示させる
		$test = Welcome2::get_hello();
		var_dump($test);
		return Response::forge(View::forge('welcome/index'));
	}
}   