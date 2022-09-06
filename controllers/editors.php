<?php
require_once('../config/init.php');

$user = new User();
$request = new General('editors');
$constants = new Constants();

$backto = Input::get('backto') ? Input::get('backto') : '../administrator';

if (!empty($_POST)) {
    Session::put('form_data', $_POST);
}

if (
    $user->isLoggedIn() &&
    Input::exists() &&
    Input::get('rq')
) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        switch (Input::get('rq')) {
            case 'about-us':
                $validation = $validate->check($_POST, array(
                    'about-us' => array(
                        'required' => true,
                    ),
                ));
                break;
        }

        if ($validation->passed()) {
            switch (Input::get('rq')) {
                case 'about-us':
                    try {
                        // send request
                        $request->update(array(
                            'text' => Input::get('about-us'),
                        ), 1);

                        Session::flash('success', 'Submitted Successfully.');
                        Session::delete('form_data');
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
