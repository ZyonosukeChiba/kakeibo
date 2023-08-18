<?php 

namespace Ss;

class Model_Tasks extends \Model {

    public static function task_add($date, $task_content)
    {
        \DB::insert('tasks')->set(array(
            'date' => $date,
            'tasks' => $task_content
        ))->execute();
    }
}
