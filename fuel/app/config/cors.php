<?php
return array(
    'default' => array(
        'allow_origin' => array('*'),
        'allow_methods' => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'),
        'allow_headers' => array('Content-Type', 'Authorization'),
        'max_age' => 3600,
        'expose_headers' => array(),
    ),
);
