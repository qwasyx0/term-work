<?php
define('DB_HOST', 'localhost:3050');
define('DB_USER', 'sysdba');
define('DB_PASSWORD', 'masterkey');
define('DB_NAME', 'win_ekonom');
define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);