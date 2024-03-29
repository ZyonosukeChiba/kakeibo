<?php 
namespace Model;

class Model extends \Model {

    public static function kform($email,$date,$title,$price)
    {
        \DB::insert('kaeibo')->set(array(
            'date'=>$date,
            'title'=>$title,
            'price'=>$price,
            'email'=>$email
        ))->execute();
    }
    public static function income($email,$date2,$income_name,$price2)
    { \DB::insert('income')->set(array(
        'date2'=>$date2,
        'income_name'=>$income_name,
        'price2'=>$price2,
        'email'=>$email
       
        ))->execute();
    }

    public static function kform2($email,$date,$title,$price,$edit_id)
    {
        \DB::update('kaeibo')->set(array(
            'date'=>$date,
            'title'=>$title,
            'price'=>$price,
            'email'=>$email
        )) ->where('id', '=', $edit_id)
        ->execute();
    }
    public static function income2($email,$date2,$income_name,$price2,$edit_id2)
    { \DB::update('income')->set(array(
        'date2'=>$date2,
        'income_name'=>$income_name,
        'price2'=>$price2,
        'email'=>$email

        ))->where('id', '=', $edit_id2)
        ->execute();
    }
    public static function delete($deleteId)
    { \DB::delete('kaeibo')
        ->where('id', '=', $deleteId)
        ->execute();
    }
    public static function delete2($deleteId2)
    { \DB::delete('income')
        ->where('id', '=', $deleteId2)
        ->execute();
    }
    public static function task_add($date,$task_content,$email)
    {
        \DB::insert('tasks')->set(array(
            'date' => $date,
            'task' => $task_content,
            'email'=>$email

        ))->execute();
    }



}

