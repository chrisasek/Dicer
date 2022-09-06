<?php
class Token
{
	public static function generate()
	{
		$tokenName = Config::get('session/token_name');
		return Session::exists($tokenName) ? Session::get($tokenName) : Session::put($tokenName, md5(uniqid()));
	}

	public static function check($token)
	{
		$tokenName = Config::get('session/token_name');
		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
	}
}
