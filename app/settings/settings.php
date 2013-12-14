<?php

$settings = array();

$settings['default_controller'] = 'calculator';

$settings['environment'] = 'DEVELOPMENT';

$settings['debug'] = false;

$settings['site_name'] = 'My MVC from scratch';

$settings['base_url'] = 'http://www.mypage.com/';

$settings['autoload_extensions'] = array();

$settings['autoload_libraries'] = array('cache', 'fURL', 'fRequest','fSession','fCRUD');

$settings['cache_time'] = -1; //in seconds. -1 is disable cache