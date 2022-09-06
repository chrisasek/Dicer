<?php
require_once('../../config/init.php');

$user = new User();
$request = new General('requests');
$constants = new Constants();

if (!empty($_POST)) {
  Session::put('form_data', $_POST);
}

$backto = Input::get('backto') ? Input::get('backto') : '../request';

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
          'fullname' => array(
            'required' => true,
            'min' => 2,
            'max' => 80,
          ),
          'phone' => array(
            'required' => true,
            'min' => 11,
            'max' => 14,
          ),
          'address' => array(
            'required' => true,
            'min' => 5,
            'max' => 200,
          ),
          'summary' => array(
            'required' => true,
            'min' => 5,
            'max' => 1000,
          ),
        ));
        break;
    }



    if ($validation->passed()) {
      try {
        // send request

        $request->create(array(
          'name' => Input::get('fullname'),
          'phone' => Input::get('phone'),
          'address' => Input::get('address'),
          'summary' => Input::get('summary'),
          'prison' => Input::get('prison'),
          'location' => Input::get('plocation'),
          'date_added' => date('Y-m-d H:i:s', time()),
        ));

        Messages::send("A new report have been submitted.", "New Report");

        Session::flash('success', 'Report Sent Successfully.');
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
