<?php



return array(
    'is_unique_email' => function($value, $options = array(), $data = array()) {

        // 例えば、データベースクエリなどを使用して重複を確認する必要があります
        $existingEmail = \Model_User::find_by('email', $value);
        return $existingEmail === null;
    }
);

