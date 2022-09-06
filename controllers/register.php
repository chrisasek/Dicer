<?php
require_once('../config/init.php');

$user = new User();
$wallet = new General('wallets');
$profile = new General('profiles');
$constants = new Constants();

if (!empty($_POST)) {
	Session::put('reg_data', $_POST);
}

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		//echo "I have been ran <br />";
		$validate = new Validate();
		// validate
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 4,
				'max' => 10,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password'
			),
			'fullname' => array(
				'required' => true,
				'min' => 2,
			),
			'email' => array(
				'required' => true,
				'min' => 2,
				'max' => 50,
				'validemail' => true,
				'unique' => 'users'
			),
			'phone' => array(
				'required' => true,
				'min' => 9,
				'max' => 14,
				'validNumber' => true
			),

			'matric' => array(
				'required' => true,
				'max' => 50,
			),
			'faculty' => array(
				'required' => true,
			),
			'dept' => array(
				'required' => true,
			),
			'level' => array(
				'required' => true,
				'min' => 3,
				'validNumber' => true
			),
			'state' => array(
				'required' => true,
			),
			'nationality' => array(
				'required' => true,
			),
			'gender' => array(
				'required' => true,
			),
			'dob' => array(
				'required' => true,
				'validDate' => true,
			),
		));


		if ($validation->passed()) {

			$salt = Hash::salt(32);
			$db = DB::getInstance();
			try {
				// create user
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'email' => Input::get('email'),
					'phone' => Input::get('phone'),
					'salt' => $salt,
					'name' => Input::get('fullname'),
					'joined' => date('Y-m-d H:i:s', time()),
					'group' => 1,
				));
				// insert student data
				if ($db->lastInsertId()) {
					$inserted = $db->lastInsertId();
					// Init wallet
					$profile->create(array(
						'user_id' => $inserted,
						'matric' => Input::get('matric'),
						'level' => Input::get('level'),
						'faculty' => Input::get('faculty'),
						'dept' => Input::get('dept'),
						'state' => Input::get('state'),
						'nationality' => Input::get('nationality'),
						'gender' => Input::get('gender'),
						'dob' => Input::get('dob'),
					));

					$wallet->create(array(
						'user_id' => $inserted,
						'bal' => 0,
						'date_added' => date('Y-m-d H:i:s', time()),
					));
				}

				$login = $user->login(Input::get('username'), Input::get('password'));

				Session::flash('success', 'Registration Successfull');
				Session::delete('reg_data');

				if ($login) {
					Redirect::to('../dashboard/home');
				} else {
					Session::flash('error', $constants->getText('ACCOUNT_REDIRECTION_FAILED'));
				}
			} catch (Exception $e) {
				Session::flash('error', $e->getMessage());
			}
		} else {
			Session::flash('error', $validation->errors());
		}
	} else {
		Session::flash('error', $constants->getText('INVALID_TOKEN'));
	}
} else {
	Session::flash('error', $constants->getText('INVALID_ACTION'));
}

Redirect::to('../register');
