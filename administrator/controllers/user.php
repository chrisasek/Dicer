<?php
require_once("../core/init.php");
$user = new User();
$profile = new General('profiles');
$constants = new Constants();
$backto = Input::get('backto') ? Input::get('backto') : '../profile';

if (
	$user->isLoggedIn() &&
	$user->isAdmin() &&
	Input::exists('get') &&
	Input::get('rq')
) {
	switch (trim(Input::get('rq'))) {
		case 'delete':
			$found = Input::get('id') ? $user->get(Input::get('id')) : null;
			if ($found) {
				$user->remove($found->id);
				Session::flash('success', "Deleted Successfully");
				Redirect::to($backto);
			}
			Session::flash('error', "Something went wrong somewhere!");
			Redirect::to($backto);
			break;
	}
}

if (
	$user->isLoggedIn() &&
	Input::exists() &&
	Input::get('rq')
) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		switch (trim(Input::get('rq'))) {
			case 'add-admin':
				// determine dashboard
				$backto = '../users';
				// validate
				$validation = $validate->check($_POST, array(
					'username' => array(
						'required' => true,
						'min' => 4,
						'max' => 10,
						'unique' => 'users'
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

				));
				break;
			case 'update-admin':
				// determine dashboard
				$backto = '../profile';
				// validate
				$validation = $validate->check($_POST, array(
					'fullname' => array(
						'required' => true,
						'min' => 2,
					),
					'phone' => array(
						'required' => true,
						'min' => 9,
						'max' => 14,
						'validNumber' => true
					),

				));
				break;
		}

		if ($validation->passed()) {
			switch (trim(Input::get('rq'))) {
				case 'add-admin':
					$salt = Hash::salt(32);
					try {
						$user->create(array(
							'username' => Input::get('username'),
							'password' => Hash::make(Input::get('password'), $salt),
							'email' => Input::get('email'),
							'phone' => Input::get('phone'),
							'salt' => $salt,
							'name' => Input::get('fullname'),
							'joined' => date('Y-m-d H:i:s', time()),
							'group' => 2,
						));
						Session::flash('success', "Admin was successfully added.");
						Redirect::to($backto);
					} catch (Exception $e) {
						Session::flash('error', $e->getMessage());
						Redirect::to($backto);
					}
					break;
				case 'update-admin':
					$salt = Hash::salt(32);
					try {
						if (Input::get('newpassword')) {
							$user->update(array(
								'password' => Hash::make(Input::get('newpassword'), $salt),
								'salt' => $salt,
							), $user->data()->id);
						}
						$user->update(array(
							'phone' => Input::get('phone'),
							'name' => Input::get('fullname'),
						), Input::get('id'));
						Session::flash('success', "Admin was successfully updated.");
						Redirect::to($backto);
					} catch (Exception $e) {
						Session::flash('error', $e->getMessage());
						Redirect::to($backto);
					}
					break;
				case 'update':
					$salt = Hash::salt(32);
					try {
						if (Input::get('newpassword')) {
							$user->update(array(
								'password' => Hash::make(Input::get('newpassword'), $salt),
								'salt' => $salt,
							), $user->data()->id);
						}

						$profile->update(array(
							'matric' => Input::get('matric'),
							'level' => Input::get('level'),
							'faculty' => Input::get('faculty'),
							'dept' => Input::get('dept'),
							'state' => Input::get('state'),
							'nationality' => Input::get('nationality'),
							'gender' => Input::get('gender'),
							'dob' => Input::get('dob'),
						), $user->data()->id, 'user_id');

						Session::flash('success', "Update Successfull.");
						Redirect::to($backto);
					} catch (Exception $e) {
						Session::flash('error', $e->getMessage());
						Redirect::to($backto);
					}
					break;
			}
		} else {
			Session::put('error', $validation->errors());
			Redirect::to($backto);
			die();
		}
	} else {
		Session::flash('error', $constants::INVALID_TOKEN);
		Redirect::to($backto);
		die();
	}
} else {
	Session::flash('error', $constants::INVALID_REQUEST);
	Redirect::to($backto);
	die();
}
