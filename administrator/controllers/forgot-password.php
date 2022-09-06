<?php
require_once('../../config/init.php');

$user = new User();
$constants = new Constants();
$profiles = new General('profiles');
$backto = Input::get('backto') ? '../' . Input::get('backto') : '../forgot-password';

if (
    Input::exists() &&
    Input::get('rq')
) {
    if (Input::get('token')) {
        $validate = new Validate();
        switch (Input::get('rq')) {
            case 'forgot':
                $validation = $validate->check($_POST, array(
                    'email' => array(
                        'required' => true,
                    ),
                ));
                break;
            case 'reset':
                $backto = '../forgot-password/reset?token=' . Input::get('reset_token');
                $validation = $validate->check($_POST, array(
                    'password' => array(
                        'required' => true,
                        'min' => 6
                    ),
                ));
                break;
        }

        if ($validation->passed()) {
            switch (Input::get('rq')) {
                case 'forgot':
                    try {
                        $us = $user->get(Input::get('email'), 'email');

                        if ($us) {
                            $token = $us->salt;
                            Messages::passwordReset($token, $us->email);
                            $backto = "../forgot-password/reset?reset_token=" . $token;
                        } else {
                            Session::flash('error', "Ooops! We didn't find your email registered.");
                        }

                        Redirect::to($backto);
                    } catch (Exception $e) {
                        Session::flash('error', $e->getMessage());
                    }
                    break;
                case 'reset':
                    try {
                        $us = $user->get(Input::get('reset_token'), 'salt');

                        // print_r($_POST); die;
                        if ($us) {
                            $salt = Hash::salt(32);
                            $db = DB::getInstance();

                            // print_r($_POST);
                            // print_r('here'); die;

                            $user->update(array(
                                'password' => Hash::make(Input::get('password'), $salt),
                                'salt' => $salt,
                            ), $us->id);

                            Session::put('thanks-password-reset', true);
                            $backto = '../forgot-password/thanks';
                        } else {
                            Session::flash('error', "Ooops! Something went wrong reseting your password</br>Please Try Again!.");
                        }

                        Redirect::to($backto);
                    } catch (Exception $e) {
                        Session::flash('error', $e->getMessage());
                    }
                    break;
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

Redirect::to($backto);
