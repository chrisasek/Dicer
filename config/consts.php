<?php
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_NAME') ? NULL : define('SITE_NAME', 'Netprolaw');
defined('SITE_URL') ? NULL : define('SITE_URL', '/github/dicer/');
defined('SITE_ADMIN_URL') ? NULL : define('SITE_ADMIN_URL', SITE_URL . 'administrator/');

defined('SITE_ROOT') ? NULL : define('SITE_ROOT', 'C:' . DS . 'xampp' . DS . 'htdocs' . DS . 'github' . DS . "dicer");
defined('SITE_ADMIN_ROOT') ? NULL : define('SITE_ADMIN_ROOT', SITE_ROOT . DS . 'administrator');

defined('MODELS_PATH') ? NULL : define('MODELS_PATH', SITE_ROOT . DS . "models/");
defined('CONFIG_PATH') ? NULL : define('CONFIG_PATH', SITE_ROOT . DS . "config/");
defined('ASSETS_PATH') ? NULL : define('ASSETS_PATH', SITE_ROOT . DS . "assets/");
