<?php 

namespace Model;

class Tasks extends \Model {

    public static function task_add($date,$task_content,$email)
    {
        \DB::insert('tasks')->set(array(
            'date' => $date,
            'task' => $task_content,
            'email'=>$email

        ))->execute();
    }

    public static function task_get($email)
    {
        $tasks = \DB::select()
        ->from('tasks')
        ->where('email', '=',$email)
        ->execute()
        ->as_array();

        return $tasks;
}
}