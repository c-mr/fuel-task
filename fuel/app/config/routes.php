<?php
return [
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route

    'hello(/:name)?' => ['welcome/hello', 'name' => 'hello'],

    'staff(/:name)?' => [
        'staff/index', 'name' => 'staff',
        'staff/add', 'name' => 'staff',
        'staff/edit', 'name' => 'staff',
        'staff/detail', 'name' => 'staff',
    ]
];
