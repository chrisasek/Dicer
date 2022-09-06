<?php
require_once('../config/init.php');
$user = new User();

if ($user->loginUser()) {
	Session::flash('success', "Account Login Successfull");
	Redirect::to('../home');
} else {
	Session::flash('error', "Failed to Login, Try Again!");
	Redirect::to('../');
}
