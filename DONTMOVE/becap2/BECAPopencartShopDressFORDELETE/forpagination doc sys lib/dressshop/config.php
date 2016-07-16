<?php
// HTTP
define('HTTP_SERVER', 'http://vam.nichost.ru/');

// HTTPS
define('HTTPS_SERVER', 'http://vam.nichost.ru/');

// DIR
define('DIR_APPLICATION', '/home/vam/vam.nichost.ru/docs/catalog/');
define('DIR_SYSTEM', '/home/vam/vam.nichost.ru/docs/system/');
define('DIR_LANGUAGE', '/home/vam/vam.nichost.ru/docs/catalog/language/');
define('DIR_TEMPLATE', '/home/vam/vam.nichost.ru/docs/catalog/view/theme/');
define('DIR_CONFIG', '/home/vam/vam.nichost.ru/docs/system/config/');
define('DIR_IMAGE', '/home/vam/vam.nichost.ru/docs/image/');
define('DIR_CACHE', '/home/vam/vam.nichost.ru/docs/system/cache/');
define('DIR_DOWNLOAD', '/home/vam/vam.nichost.ru/docs/system/download/');
define('DIR_UPLOAD', '/home/vam/vam.nichost.ru/docs/system/upload/');
define('DIR_MODIFICATION', '/home/vam/vam.nichost.ru/docs/system/modification/');
define('DIR_LOGS', '/home/vam/vam.nichost.ru/docs/system/logs/');

define('HTTP_THEME', HTTP_SERVER . 'catalog/view/theme/new/');
define('HTTP_IMAGE', HTTP_SERVER . 'image/');
define('BREAD_TPL', DIR_APPLICATION . 'view/theme/new/template/common/bread.tpl');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'vam.mysql');
define('DB_USERNAME', 'vam_mysql');
define('DB_PASSWORD', 'Ee4/LhqU');
define('DB_DATABASE', 'vam_db');
define('DB_PREFIX', 'oc_');
define('DB_PORT', '3306');