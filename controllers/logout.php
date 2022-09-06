<?php
require_once('../config/init.php');
$user = new User();
if ($user->isLoggedIn()) {
	$user->logOut();
}

Redirect::to('../');
