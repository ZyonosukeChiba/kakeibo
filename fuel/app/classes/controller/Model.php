<?php 
namespace Model;

class Welcome extends \Model {

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



}

