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


 use \Model\Sample;

 header('Access-Control-Allow-Origin: *');
class Controller_1 extends Controller
{
public function action_t(){
	return View::forge('signin2');
}
public function action_q(){
	return View::forge('1');
}

public function action_s(){
	return View::forge('chart2');
}

public function action_s2(){
	return View::forge('chart3');
}
public function action_test() {
	// モデルから取得したデータを表示
	$rows = Sample::get_results();
	var_export($rows);
}

}