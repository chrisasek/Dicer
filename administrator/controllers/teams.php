<?php
require_once('../../config/init.php');

$user = new User();
$constants = new Constants();
$teams = new General('teams');

$backto = Input::get('backto') ? '../' . Input::get('backto') : '../teams';

if (
  $user->isLoggedIn() &&
  $user->isAdmin() &&
  Input::exists('get') &&
  Input::get('rq')
) {
  switch (trim(Input::get('rq'))) {
    case 'status':
      $found = Input::get('id') ? $teams->get(Input::get('id')) : null;
      if ($found) {
        $teams->update(array('status' => $found->status ? 0 : 1,), $found->id);
        Session::flash('success', "Status updated successfully");
        Redirect::to($backto);
      }
      Session::flash('error', "Something went wrong somewhere!");
      Redirect::to($backto);
      break;
    case 'delete':
      $found = Input::get('id') ? $teams->get(Input::get('id')) : null;
      if ($found) {
        if ($image && $found->featured_image && $found->featured_image != 'default.jpg') {
          Helpers::deleteFile("../media/images/team/" . $found->featured_image);
          Helpers::deleteFile("../media/images/resized/team/" . $found->featured_image);
        }
        $teams->remove($found->id);
        Session::flash('success', "Deleted Successfully");
        Redirect::to($backto);
      }
      Session::flash('error', "Something went wrong somewhere!");
      Redirect::to($backto);
      break;
  }
}

//print_r($_POST);die;

if (
  Input::exists() &&
  $user->isLoggedIn() &&
  $user->isAdmin() &&
  Input::get('rq')
) {

  if (Token::check(Input::get('token'))) {
    $validate = new Validate();
    switch (trim(Input::get('rq'))) {
      case 'add':
        $validation = $validate->check($_POST, array(
          'name' => array(
            'required' => true,
            'min' => 2,
          ),
          'position' => array(
            'required' => true,
          ),
          'profile' => array(
            'required' => true,
          ),
        ));
        $backto = '../teams';
        break;
      case 'edit':
        $validation = $validate->check($_POST, array(
          'name' => array(
            'required' => true,
            'min' => 2,
          ),
          'position' => array(
            'required' => true,
          ),
          'profile' => array(
            'required' => true,
          ),
        ));
        $backto = '../teams/edit/' . Input::get('id');
        break;
    }

    // if validation is passed
    if ($validation->passed()) {
      if (!empty($_FILES) && $_FILES['featured']['error']['0'] === 0) {

        if ($validate->checkFiles($_FILES['featured'], 'file', 1)->passed()) {
          //print_r( 'passed'); die;
          foreach ($_FILES['featured']['name'] as $index => $files) {
            $temp = explode(".", $_FILES["featured"]["name"][$index]);
            $fname = Input::get('name');
            $newfilename = $fname . '.' . end($temp);
            // check path
            $path = (file_exists("../media/images/team/") && is_writeable("../media/images/team/")) ? "../media/images/team/" : (mkdir("../media/images/team/", 0777, true) ? "../media/images/team/" : "../media/");
            // preview path
            $prevPath = (file_exists("../media/images/resized/team/") && is_writeable("../media/images/resized/team/")) ? "../media/images/resized/team/" : (mkdir("../media/images/resized/team/", 0777, true) ? "../media/images/resized/team/" : "../media/");

            // move and create preview
            if (move_uploaded_file($_FILES["featured"]["tmp_name"][$index], $path . $newfilename) && $validate->imagePreviewSize($path . $newfilename, $prevPath, $fname, 160, 260)) {
              // && $validate->imagePreviewSize($path.$newfilename, $prevPath, $fname, 400, 400)
              $image = $newfilename;
            }
          }
          $image = isset($image) ? $image : null;
        }
      }
    }

    if ($validation->passed()) {
      switch (trim(Input::get('rq'))) {
        case 'add':
          try {
            // create user
            $teams->create(array(
              'name' => Input::get('name'),
              'position' => Input::get('position'),
              'profile' => Input::get('profile'),
              'image' => $image ? $image : 'default.jpg',
            ));
            Session::flash('success', 'Added Successfully');
            Redirect::to($backto);
          } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            if ($image) {
              Helpers::deleteFile("../media/images/team/" . $image);
              Helpers::deleteFile("../media/images/resized/team/" . $image);
            }
          }
          break;
        case 'edit':
          try {
            $found = $teams->get(Input::get('id'));
            if ($found) {
              $feat_img = $found->image;

              $teams->update(array(
                'name' => Input::get('name'),
                'position' => Input::get('position'),
                'profile' => Input::get('profile'),
                'image' => $image ? $image : $found->image,
              ), $found->id);

              if ($image && $feat_img && $feat_img != 'default.jpg') {
                Helpers::deleteFile("../media/images/team/" . $feat_img);
                Helpers::deleteFile("../media/images/resized/team/" . $feat_img);
              }

              Session::flash('success', 'Added Successfully');
              Redirect::to("../administrator/teams");
            } else {
              Session::flash('error', 'Something went wrong, try again');
            }
            Redirect::to($backto);
          } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            if ($image) {
              Helpers::deleteFile("../media/images/team/" . $image);
              Helpers::deleteFile("../media/images/resized/team/" . $image);
            }
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
