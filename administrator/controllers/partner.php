<?php
require_once('../../config/init.php');

$user = new User();
$request = new General('partners');
$constants = new Constants();

if (!empty($_POST)) {
    Session::put('form_data', $_POST);
}

$backto = Input::get('backto') ? Input::get('backto') : '../get-involved';

if (Input::get('rq') && Input::get('rq') == 'delete' && Input::get('id')) {
    $request->remove(Input::get('id'));
    Session::flash('success', 'Request Deleted Successfully');
    Redirect::to($backto);
}

if (Input::get('rq') && Input::get('rq') == 'status' && Input::get('id')) {
    $backto = "../administrator/home";
    $request->update(array(
        'status' => Input::get('status')
    ), Input::get('id'));
    Session::flash('success', 'Request Status Updated Successfully');
    Redirect::to($backto);
}

if (
    Input::exists() &&
    Input::get('rq')
) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        switch (Input::get('rq')) {
            case 'make-request':
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'required' => true,
                    ),
                    'phone' => array(
                        'required' => true,
                        'min' => 11,
                        'max' => 16,
                    ),
                    'email' => array(
                        'required' => true,
                        'validemail' => true,
                    ),
                    'message' => array(
                        'required' => true,
                        'min' => 5
                    ),
                ));
                break;
        }



        if ($validation->passed()) {
            try {
                // send request
                $request->create(array(
                    'name' => Input::get('name'),
                    'phone' => Input::get('phone'),
                    'message' => Input::get('message'),
                    'email' => Input::get('email'),
                ));

                Messages::send("New partnership request have been submitted.", "New Partnership Request");

                Session::flash('success', 'Sent Successfully, you will be contacted shortly.');
                Session::delete('form_data');
                Redirect::to($backto);
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

Redirect::to($backto);
