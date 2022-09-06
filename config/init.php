<?php
session_start();

require_once('consts.php');

// show all errors for now
error_reporting(E_ALL);

// Using African time zone
date_default_timezone_set('Africa/Lagos');


// global configuration array
$GLOBALS['config'] = array(
	// DB setup
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'github_dicer'
	),

	// Change Cookie name to yours
	'remember' => array(
		'cookie_name' => 'oniontabs_dicer_hash',
		'cookie_expiry' => 604800
	),

	// Change Session name to yours
	'session' => array(
		'session_name' => 'oniontabs_dicer_user',
		'token_name' => 'oniontabs_dicer_token'
	)
);
/**
The function below helps you include and autoload a class once and only when required!
 **/
spl_autoload_register(function ($class) {
	require_once(MODELS_PATH . DS . strtolower($class) . '.php');
});

//require_once('functions/sanitize.php');
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
