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


 


 use \Model\Tasks;


class Controller_1 extends Controller_Rest
{
    public function post_add()
    {
      
        $response = ['success' => false];
        try {
            // POSTデータの取得
            $date = Input::post('date');
            $task_content = Input::post('task');
            $email = Session::get('email');

            // データのバリデーション (簡易的に)
            if (empty($date) || empty($task_content)) {
                throw new Exception("データが不足しています");
            }

           
            Tasks::task_add($date, $task_content, $email);

            // 成功レスポンスの設定
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
       
        $email = Session::get('email');
        try {
            // tasksテーブルから全てのデータを取得
            $tasks=Tasks::task_get($email);
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }


public function get_payment(){
    $email = Session::get('email');
    $result = DB::select('id', 'date', 'title', 'price')
    ->from('kaeibo')
    ->where('email', '=', $email)
    ->execute()
    ->as_array();

   
      return $this->response(['success' => true, 'result' => $result], 200);
    }
 public function get_incomes()
    {
        $email = Session::get('email');
        $result = DB::select('id', 'date2', 'price2')
            ->from('income')
            ->where('email', '=', $email)
            ->execute()
            ->as_array();

        return $this->response(['success' => true, 'result' => $result], 200);
    }

  



   

    public function put_update()
{
    try {
        // クライアントから送られてくるデータを取得
        $id = Input::put('id');
        $newTask = Input::put('newTask');
        $email = Session::get('email');


        // tasksテーブルから指定されたIDのタスクを更新
        \DB::update('tasks')
            ->set(['task' => $newTask])
            ->where('id', '=',  $id)
            ->where('email', '=',$email)
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

public function post_add2()
        {
            $response = ['success' => false];
    
            try {
                // POSTデータの取得
                $date = Input::post('date');
                $task_content = Input::post('task');
                $email = Session::get('other_email');
                // データのバリデーション (簡易的に)
                if (empty($date) || empty($task_content)) {
                    throw new Exception("データが不足しています");
                }

                \DB::insert('tasks')->set(array(
                    'date' => $date,
                    'task' => $task_content,
                    'email'=>$email

                ))->execute();

            

                $response['success'] = true;
    
            } catch (Exception $e) {
                // エラーメッセージの設定
                $response['error_message'] = $e->getMessage();
            }
    
            // JSONレスポンスを返す
            return $this->response($response, ($response['success'] ? 200 : 500));
            
        }
  
    public function get_tasks2()
    {
        $email = Session::get('other_email');
        try {
            // tasksテーブルから全てのデータを取得
            $tasks = \DB::select()
            ->from('tasks')
            ->where('email', '=',$email)
            ->execute()
            ->as_array();
            
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }


public function get_payment2(){
    $email = Session::get('other_email');
    $result = DB::select('id', 'date', 'title', 'price')
    ->from('kaeibo')
    ->where('email', '=', $email)
    ->execute()
    ->as_array();

   
      return $this->response(['success' => true, 'result' => $result], 200);
    }
  



   

    public function put_update2()
{
    try {
        // クライアントから送られてくるデータを取得
        $id = Input::put('id');
        $newTask = Input::put('newTask');
        $email = Session::get('other_email');


        // tasksテーブルから指定されたIDのタスクを更新
        \DB::update('tasks')
            ->set(['task' => $newTask])
            ->where('id', '=',  $id)
            ->where('email', '=',$email)
            ->execute();

       // 成功したレスポンスを返す
        return $this->response(['success' => true], 200);
    } catch (\Exception $e) {
        // エラーメッセージを設定し、エラーレスポンスを返す
        return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
    }
}
    public function put_done2()
{
    try {
        // クライアントから送られてくるデータを取得
        $id = Input::put('id');

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

public function delete_deletetask2()
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

public function put_createGroup()
{
    try {
        $group = Input::put('group');
        $email = Session::get('email');

 // tasksテーブルから指定されたIDのタスクを更新
 \DB::update('users')
 ->set(['group' => $group])
 ->where('email', '=',$email)
 ->execute();
 return $this->response(['success' => true], 200);
    }catch (\Exception $e) {
        // エラーメッセージを設定し、エラーレスポンスを返す
        return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
    }

    }


    public function post_comment()
    {
        $response = ['success' => false];

        try {
            // POSTデータの取得
            $date = Input::post('date');
            $comment = Input::post('comment');
            $user = Input::post('user');
            
            $email = Session::get('email');
            // データのバリデーション (簡易的に)
            

            \DB::insert('comment')->set(array(
                'month' => $date,
                'comment' => $comment,
                'email'=>$email,
                'user'=>$email

            ))->execute();

        

            $response['success'] = true;

        } catch (Exception $e) {
            // エラーメッセージの設定
            $response['error_message'] = $e->getMessage();
        }

        // JSONレスポンスを返す
        return $this->response($response, ($response['success'] ? 200 : 500));
        
    }

    public function get_comment1()
    {
        $email = Session::get('email');
        try {
            // tasksテーブルから全てのデータを取得
            $tasks = \DB::select()
            ->from('comment')
            ->where('email', '=',$email)
            ->order_by('id', 'DESC')  // 'date'はコメントの日付を保持するカラム名を仮定しています。実際のカラム名に変更してください。
            ->limit(10)
            ->execute()
            ->as_array();
            
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }
    public function post_comment2()
    {
        $response = ['success' => false];

        try {
            // POSTデータの取得
            $date = Input::post('date');
            $comment = Input::post('comment');
            $email = Session::get('other_email');
            $user = Session::get('email');
         
            

            \DB::insert('comment')->set(array(
                'comment' => $comment,
                'email'=>$email,
                'user'=>$user

            ))->execute();

        

            $response['success'] = true;

        } catch (Exception $e) {
            // エラーメッセージの設定
            $response['error_message'] = $e->getMessage();
        }

        // JSONレスポンスを返す
        return $this->response($response, ($response['success'] ? 200 : 500));
        
    }

    public function get_comment3()
    {
        $email = Session::get('other_email');
        try {
            // tasksテーブルから全てのデータを取得
            $tasks = \DB::select()
            ->from('comment')
            ->where('email', '=',$email)
            ->order_by('id', 'DESC')  // 'date'はコメントの日付を保持するカラム名を仮定しています。実際のカラム名に変更してください。
            ->limit(10)
            ->execute()
            ->as_array();
            
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }
    

public function post_commentv()
{
    $response = ['success' => false];

    try {
        $comment = Input::post('comment');
        $email = Session::get('email');

        $group = \DB::select('group')
            ->from('users')
            ->where('email', '=', $email)
            ->execute();
        $usergroup = $group->current();

        \DB::insert('comment')->set(array(
            'comment' => $comment,
            'email' => $email,
            'user' => $email,
            'group_name' => $usergroup,
        ))->execute();

        // 同じグループの全員のメールアドレスを取得
        $groupMembers = \DB::select('email')
            ->from('users')
            ->where('group', '=', $usergroup)
            ->execute()
            ->as_array();

        $subject = "New Message";
        $message = "New message at KAKEIBO APP";
       $headers = "From:$email ";

        foreach ($groupMembers as $member) {
            mail($member['email'], $subject, $message, $headers);
        }

        $response['success'] = true;

    } catch (Exception $e) {
        // エラーメッセージの設定
        $response['error_message'] = $e->getMessage();
    }

    // JSONレスポンスを返す
    return $this->response($response, ($response['success'] ? 200 : 500));
}


    public function get_commentv2()
    {  $email = Session::get('email');
        // $email='aaa@gmail.com';

        $group = \DB::select('group')
        ->from('users')
        ->where('email', '=',$email)
        ->execute();
        $usergroup = $group->current();


     

      
        try {

            // tasksテーブルから全てのデータを取得
            $tasks = \DB::select()
            ->from('comment')
            ->where('group_name', '=',$usergroup)
            ->execute()
            ->as_array();
            
            // 成功したレスポンスを返す
            return $this->response(['success' => true, 'tasks' => $tasks], 200);
        } catch (\Exception $e) {
            // エラーメッセージを設定し、エラーレスポンスを返す
            return $this->response(['success' => false, 'error_message' => $e->getMessage()], 500);
        }
    }

}

 
     
 
 