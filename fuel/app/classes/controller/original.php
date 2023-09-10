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

// require_once 'model/Model.php';

use \Model\Model;

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
    {try {

        if ($this->request->action === 'kakeibo_form_insert') {
            $this->action_authCheck_For_Specific_Methods();
        } else if ($this->request->action === 'income_form_insert') {
            $this->action_authCheck_For_Specific_Methods();
        }} catch (Exception $e) {
        // エラーが発生した場合の処理
        $error_code = $e->getCode();
        // リダイレクトを行う
        Response::redirect('original/login/', $error_code); // リダイレクト先のURLを指定

    }
    }
    private function action_authCheck_For_Specific_Methods()
    {
        if (!Auth::check() == 'ture') {
            Response::redirect('original/login/');
        }
    }

//初期画面表示
 
   
    public function action_display_kakeibo_chart_data()
    {
        return View::forge('kakeibo_chart_data');
    }
    public function action_display_income_chart_data()
    {
        return View::forge('income_chart_data');
    }
    public function action_display_chart()
    {
        return View::forge('chart');
    }
    public function action_view()
    {
        return View::forge('main');
    }

    public function action_display_year()
    {
        return View::forge('year');
    }

    public function action_display_signup()
    {
        return View::forge('signup');
    }

//emailをセッションに保存
    public function action_email()
    {
        \Session::instance()->start();
        $email = Input::post('email'); // フォームからemailの値を取得
        \Session::set('email', $email);

        return View::forge('main');
    }

    public function action_kakeibo_form_insert()
    {

        if (Input::post()) {
            $email = Session::get('email');
            $val = Validation::forge();
            $val->add_field('date', '日付', 'required');
            $val->add_field('title', '分類', 'required');
            $val->add_field('price', '金額', 'required');
            if ($val->run()) {
                $date = Input::post('date');
                $title = Input::post('title');
                $price = Input::post('price');

                $kform = new Model();
                $kform->kform($email, $date, $title, $price);

            } else {
                foreach ($val->error() as $key => $value) {
                    echo $value->get_message();
                }exit;
            }
        }
        return View::forge('main');

    }

    public function action_income_form_insert()
    {

        if (Input::post()) {
            $email = Session::get('email');
            $val = Validation::forge();
            $val->add_field('date2', '日付', 'required');
            $val->add_field('income_name', '分類', 'required');
            $val->add_field('price2', '金額', 'required');
            if ($val->run()) {
                $date2 = Input::post('date2');
                $income_name = Input::post('income_name');
                $price2 = Input::post('price2');

                $income = new Model();
                $income->income($email, $date2, $income_name, $price2);

            } else {
                foreach ($val->error() as $key => $value) {
                    echo $value->get_message();
                }
                exit;

            }
        }

        return View::forge('main');

    }

    public function action_kakeibo_form_update()
    {

        if (Input::post()) {
            $email = Session::get('email');
            $val = Validation::forge();
            $val->add_field('date', '日付', 'required');
            $val->add_field('title', '分類', 'required');
            $val->add_field('price', '金額', 'required');
            if ($val->run()) {
                $date = Input::post('date');
                $title = Input::post('title');
                $price = Input::post('price');
                $edit_id = Input::post('editid');

                $kform2 = new Model();
                $kform2->kform2($email, $date, $title, $price, $edit_id);

            } else {
                foreach ($val->error() as $key => $value) {

                }
                exit;

            }
        }
        return View::forge('main');
    }

    public function action_income_form_update()
    {

        if (Input::post()) {
            $email = Session::get('email');
            $val = Validation::forge();
            $val->add_field('date2', '日付', 'required');
            $val->add_field('income_name', '分類', 'required');
            $val->add_field('price2', '金額', 'required');
            if ($val->run()) {
                $date2 = Input::post('date2');
                $income_name = Input::post('income_name');
                $price2 = Input::post('price2');
                $edit_id2 = Input::post('editid2');
                $income2 = new Model();
                $income2->income2($email, $date2, $income_name, $price2, $edit_id2);

            } else {
                foreach ($val->error() as $key => $value) {
                    echo $value->get_message();
                }
                exit;

            }
        }return View::forge('main');
    }

    public function action_signup()
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
                return View::forge('main');
            } else {
                // 登録失敗時の処理
                echo 'ユーザーの作成に失敗しました';
                return View::forge('signin');
            }
        } else {
            // フォームが送信されていない場合の処理

            return View::forge('signup');
        }
    }

    public function action_select_month()
    {
        \Session::instance()->start();
        $month = Input::post('month');
        \Session::set('month', $month);

        return View::forge('main');
    }
    public function action_year()
    {
        \Session::instance()->start();
        $year = Input::post('year');
        \Session::set('year', $year);

        return View::forge('chart');
    }

    public function action_login()
    {
        \Session::instance()->start();
        $email = Input::post('email1'); // フォームからemailの値を取得
        \Session::set('email', $email);
        $password = Input::post('password1');
        if (input::post()) {
            if (Auth::login($email, $password)) {
                return View::forge('main');} else {
                echo 'ログインできません';
                return View::forge('login');
            }} else {echo 'フォームを入力してください';}

        return View::forge('login');
        echo 'ポストされていません';
    }

    public function action_logout()
    {
        Auth::logout();

        if (Auth::check() == 'ture') {
            echo 'ログアウト失敗';

        } else {
            echo 'ログアウトしました。';
            Response::redirect('original/login/');

        }
    }

    public function action_signout()
    {if (Input::post()) {
        $email = Input::POST('email');

        DB::delete('users')
            ->where('email', '=', $email)
            ->execute();

        Response::redirect('original/login/');}
    }

    public function action_kakeibo_delete()
    {
        if (Input::post()) {
            $deleteId = $_POST['delete_id'];
            // DB::delete('kaeibo')
            //     ->where('id', '=', $deleteId)
            //     ->execute();

			    $delete = new Model();
                $delete->delete($deleteId);


            return View::forge('main');}
			 else {
            return View::forge('main');}
    }

    public function action_income_delete()
    {
        if (Input::post()) {
            $deleteId2 = $_POST['delete_id2'];
            // DB::delete('income')
            //     ->where('id', '=', $deleteId2)
            //     ->execute();
			$delete2 = new Model();
			$delete2->delete2($deleteId2);
            return View::forge('main');
		} else {
            return View::forge('main');
        }
    }

    public function action_display_edit_kakeibo()
    {if (Input::post()) {
        $editid = $_POST['edit_id'];
// ビューを作成
        $view = View::forge('edit_kakeibo');

// 値をビューに設定
        $view->set('edit_id', $editid);

// ビューをレンダリングして返す
        return $view;

    } else {
        return View::forge('main');
    }}

    public function action_display_edit_income()
    {
        if (Input::post()) {
            $editid2 = $_POST['edit_id2'];
            // ビューを作成
            $view = View::forge('edit_income');

            // 値をビューに設定
            $view->set('edit_id2', $editid2);

            // ビューをレンダリングして返す
            return $view;
        }
    }
    public function action_view2(){
         
        $view=View::forge('date');
 
        return $view;
    }


    public function action_view3(){
        \Session::instance()->start();
            $email = Session::get('email');
            $group = \DB::select()
            ->from('users')
            ->where('email', '=',$email)
            ->execute()
            ->get('group');
   
       
   
            $group_member=\DB::select('email')
            ->from('users')
            ->where('group','=',$group)
            ->execute()
            ->as_array();
   
            
           
           $view=View::forge('date2');
          $view->set('group_member',$group_member);
          return $view;
      
    }



    public function action_see_others() {
        // Input::post('email')でemailというキーのPOSTデータを取得
        $other_email = Input::post('email');
        \log::error($other_email);
        // $other_email='113zyooo@icloud.com';
        // 取得した$other_emailをビューに渡す
        \Session::instance()->start();
        \Session::set('other_email', $other_email);
        return View::forge('date_others');
        
    }
    

    // public function action_see_others(){
    //     \Session::instance()->start();
    //      $email = Session::get('email');
    //      $group = \DB::select()
    //      ->from('users')
    //      ->where('email', '=',$email)
    //      ->execute()
    //      ->get('group');

    

    //      $group_member=\DB::select('email')
    //      ->from('users')
    //      ->where('group','=',$group)
    //      ->execute()
    //      ->as_array();

         
        
    //     $view=View::forge('select');
    //    $view->set('group_member',$group_member);
    //    return $view;
    // }



    

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
