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




class Controller_1 extends Controller{



        public function post_add() {
            try {
                // POST データを取得
                $task = Input::post('task');
                $date = Input::post('date');
    
                // ここでデータベースに保存などの操作を行う
    
                // 正常に終了した場合のレスポンス
                $response = array('status' => 'success', 'message' => 'タスクが追加されました');
            } catch (Exception $e) {
                // エラーレスポンス
                $response = array('status' => 'error', 'message' => $e->getMessage());
            }

            \Response::current()->set_header('Access-Control-Allow-Origin', '*');
            \Response::current()->set_header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            \Response::current()->set_header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, X-Requested-With');
            
    
            return $this->response($response);
        }

        public function action_view1(){
            return View::forge('date');
        }

    }
    

