<?php
require_once('../../config/init.php');

$user = new User();
$constants = new Constants();
$blogs = new General('blogs');

$backto = Input::get('backto') ? '../' . Input::get('backto') : '../blogs';

if (
  $user->isLoggedIn() &&
  $user->isAdmin() &&
  Input::exists('get') &&
  Input::get('rq')
) {
  switch (trim(Input::get('rq'))) {
    case 'status':
      $found = Input::get('id') ? $blogs->get(Input::get('id')) : null;
      if ($found) {
        $blogs->update(array('status' => $found->status ? 0 : 1,), $found->id);
        Session::flash('success', "Status updated successfully");
        Redirect::to($backto);
      }
      Session::flash('error', "Something went wrong somewhere!");
      Redirect::to($backto);
      break;
    case 'delete':
      $found = Input::get('id') ? $blogs->get(Input::get('id')) : null;
      if ($found) {
        if ($image && $found->featured_image && $found->featured_image != 'default.jpg') {
          Helpers::deleteFile("../media/images/blog/" . $found->featured_image);
          Helpers::deleteFile("../media/images/resized/blog/" . $found->featured_image);
        }
        $blogs->remove($found->id);
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
      case 'add-blog':
        $validation = $validate->check($_POST, array(
          'title' => array(
            'required' => true,
            'min' => 2,
            'unique' => 'blogs',
          ),
          'status' => array(
            'required' => true,
          ),
          'slug' => array(
            'required' => true,
          ),
        ));
        $backto = '../blogs';
        break;
      case 'edit-blog':
        $validation = $validate->check($_POST, array(
          'title' => array(
            'required' => true,
            'min' => 2,
          ),
          'slug' => array(
            'required' => true,
          ),
        ));
        $backto = '../blogs';
        break;
    }

    // if validation is passed
    if ((Input::get('rq') == 'add-blog' || Input::get('rq') == 'edit-blog') && $validation->passed()) {

      if (!empty($_FILES) && $_FILES['featured']['error']['0'] === 0) {

        if ($validate->checkFiles($_FILES['featured'], 'file', 1)->passed()) {
          //print_r( 'passed'); die;
          foreach ($_FILES['featured']['name'] as $index => $files) {
            $temp = explode(".", $_FILES["featured"]["name"][$index]);
            $fname = Helpers::getUnique(5);
            $newfilename = $fname . '.' . end($temp);
            // check path
            $path = (file_exists("../media/images/blog/") && is_writeable("../media/images/blog/")) ? "../media/images/blog/" : (mkdir("../media/images/blog/", 0777, true) ? "../media/images/blog/" : "../media/");
            // preview path
            $prevPath = (file_exists("../media/images/resized/blog/") && is_writeable("../media/images/resized/blog/")) ? "../media/images/resized/blog/" : (mkdir("../media/images/resized/blog/", 0777, true) ? "../media/images/resized/blog/" : "../media/");

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
        case 'add-blog':
          try {
            // create user
            $blogs->create(array(
              'title' => Input::get('title'),
              'subtitle' => Input::get('subtitle'),
              'category' => Input::get('category'),
              'text' => Input::get('post'),
              'slug' => Input::get('slug'),
              'featured_image' => $image ? $image : 'default.jpg',
              'status' => Input::get('status') && Input::get('status') == 'public' ? 1 : 0,
              'date_added' => date('Y-m-d H:i:s', time()),
            ));
            Session::flash('success', 'Added Successfully');
            Redirect::to($backto);
          } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            if ($image) {
              Helpers::deleteFile("../media/images/blog/" . $image);
              Helpers::deleteFile("../media/images/resized/blog/" . $image);
            }
          }
          break;
        case 'edit-blog':
          try {
            $found = $blogs->get(Input::get('id'));
            if ($found) {
              $feat_img = $found->featured_image;

              $blogs->update(array(
                'title' => Input::get('title'),
                'subtitle' => Input::get('subtitle'),
                'category' => Input::get('category'),
                'text' => Input::get('post'),
                'slug' => Input::get('slug'),
                'featured_image' => $image ? $image : $found->featured_image,
                'status' => Input::get('status') && Input::get('status') == 'public' ? 1 : 0,
              ), $found->id);

              if ($image && $feat_img && $feat_img != 'default.jpg') {
                Helpers::deleteFile("../media/images/blog/" . $feat_img);
                Helpers::deleteFile("../media/images/resized/blog/" . $feat_img);
              }

              Session::flash('success', 'Added Successfully');
            } else {
              Session::flash('error', 'Something went wrong, try again');
            }
            Redirect::to($backto);
          } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            if ($image) {
              Helpers::deleteFile("../media/images/blog/" . $image);
              Helpers::deleteFile("../media/images/resized/blog/" . $image);
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
