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


 use Fuel\Core\Input;
 use Tasks\Model_Tasks;
 
    
    
    class Controller_1 extends Controller_Rest
    {
        public function post_add()
        {
            $response = ['success' => false];
    
            try {
                // POSTデータの取得
                $date = Input::post('date');
                $task_content = Input::post('task');
    
                // データのバリデーション (簡易的に)
                if (empty($date) || empty($task_content)) {
                    throw new Exception("データが不足しています");
                }

                \DB::insert('tasks')->set(array(
                    'date' => $date,
                    'task' => $task_content
                ))->execute();

            

                $response['success'] = true;
    
            } catch (Exception $e) {
                // エラーメッセージの設定
                $response['error_message'] = $e->getMessage();
            }
    
            // JSONレスポンスを返す
            return $this->response($response, ($response['success'] ? 200 : 500));
            
        }
  
    public function get_tasks()
    {
        try {
            // tasksテーブルから全てのデータを取得
            $tasks = \DB::select()->from('tasks')->execute()->as_array();
            
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }

    public function put_update()
{
    try {
        // クライアントから送られてくるデータを取得
        $id = Input::put('id');
        $newTask = Input::put('newTask');
       



        // tasksテーブルから指定されたIDのタスクを更新
        \DB::update('tasks')
            ->set(['task' => $newTask])
            ->where('id', '=',  $id)
            ->execute();

       // 成功したレスポンスを返す
        return $this->response(['success' => true], 200);
    } catch (\Exception $e) {
        // エラーメッセージを設定し、エラーレスポンスを返す
        return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
    }
}
    public function put_done()
{
    try {
        // クライアントから送られてくるデータを取得
        $id = Input::put('id');
        $newTask = Input::put('newTask');
       



        // tasksテーブルから指定されたIDのタスクを更新
        \DB::update('tasks')
            ->set(['done' => '1'])
            ->where('id', '=',  $id)
            ->execute();

       // 成功したレスポンスを返す
        return $this->response(['success' => true], 200);
    } catch (\Exception $e) {
        // エラーメッセージを設定し、エラーレスポンスを返す
        return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
    }
}

public function delete_deletetask()
{
    try {
        // クライアントから送られてくるデータを削除
        $id = Input::delete('id');
        // tasksテーブルから指定されたIDのタスクを削除
        \DB::delete('tasks')
            ->where('id', '=',  $id)
            ->execute();

       // 成功したレスポンスを返す
        return $this->response(['success' => true], 200);
    } catch (\Exception $e) {
        // エラーメッセージを設定し、エラーレスポンスを返す
        return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
    }
}




    }
    

    
    

 
     
 
 