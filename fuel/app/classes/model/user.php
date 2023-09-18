<?php

class Model_User extends Orm\Model
{

    protected static $_properties = array(
        'id',
        'username',
        'password',
        'email',
        'group',
    );

    protected static $_table_name = 'users';

}
