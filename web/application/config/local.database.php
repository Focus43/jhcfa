<?php 
return array(
    'default-connection' => 'concrete',
    'connections' => array(
        'concrete' => array(
            'driver' => 'c5_pdo_mysql',
            'server' => 'db',
            'database' => 'c5_db',
            'username' => 'c5_user',
            'password' => 'c5_password',
            'charset' => 'utf8'
        )
    )
);