<?php
require_once('../../config/init.php');

$image = null;

$user = new User();
$programs = new General('programs');
$constants = new Constants();

$backto = Input::get('backto') ? Input::get('backto') : '../page-program';

if (Input::get('rq') && Input::get('rq') == 'delete' && Input::get('id')) {
    $p = $programs->get(Input::get('id'));
    if ($p) {
        if ($p->image && $p->image != 'default.jpg') {
            Helpers::deleteFile("../media/images/programs/" . $p->image);
            Helpers::deleteFile("../media/images/resized/programs/" . $p->image);
        }
        $programs->remove(Input::get('id'));
        Session::flash('success', 'Deleted Successfully');
    } else {
        Session::flash('error', 'Something went wrong! item not found.');
    }
    Redirect::to($backto);
}

if (Input::get('rq') && Input::get('rq') == 'status' && Input::get('id')) {
    $programs->update(array(
        'status' => Input::get('status')
    ), Input::get('id'));
    Session::flash('success', 'Status Updated Successfully');
    Redirect::to($backto);
}

if (!empty($_POST)) {
    Session::put('form_data', $_POST);
}

if (
    $user->isLoggedIn() &&
    Input::exists() &&
    Input::get('rq')
) {
    if (Input::get('rq')) { //Token::check(Input::get('token'))
        $validate = new Validate();
        switch (Input::get('rq')) {
            case 'add':
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'required' => true,
                    ),
                    'text' => array(
                        'required' => true,
                    ),
                    'status' => array(
                        'required' => true,
                    ),
                ));
                break;
            case 'edit':
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'required' => true,
                    ),
                    'text' => array(
                        'required' => true,
                    ),
                    'status' => array(
                        'required' => true,
                    ),
                ));
                break;
        }

        // if validation is passed
        if ($validation->passed()) {
            if (!empty($_FILES) && $_FILES['file']['error']['0'] === 0) {

                if ($validate->checkFiles($_FILES['file'], 'file', 1)->passed()) {

                    foreach ($_FILES['file']['name'] as $index => $files) {
                        $temp = explode(".", $_FILES["file"]["name"][$index]);
                        $fname = Helpers::getUnique(5);
                        $newfilename = $fname . '.' . end($temp);
                        // check path
                        $path = (file_exists("../media/images/programs/") && is_writeable("../media/images/programs/")) ? "../media/images/programs/" : (mkdir("../media/images/programs/", 0777, true) ? "../media/images/programs/" : "../media/");
                        // preview path
                        $prevPath = (file_exists("../media/images/resized/programs/") && is_writeable("../media/images/resized/programs/")) ? "../media/images/resized/programs/" : (mkdir("../media/images/resized/programs/", 0777, true) ? "../media/images/resized/programs/" : "../media/");

                        // move and create preview
                        if (move_uploaded_file($_FILES["file"]["tmp_name"][$index], $path . $newfilename) && $validate->imagePreviewSize($path . $newfilename, $prevPath, $fname, 150, 300)) {
                            // && $validate->imagePreviewSize($path.$newfilename, $prevPath, $fname, 400, 400)
                            $image = $newfilename;
                        }
                    }

                    $image = isset($image) ? $image : null;
                }
            }
        }

        if ($validation->passed()) {
            switch (Input::get('rq')) {
                case 'add':
                    try {
                        // Send 
                        $programs->create(array(
                            'title' => Input::get('title'),
                            'text' => nl2br(Input::get('text')),
                            'status' => Input::get('status'),
                            'image' => $image ? $image : 'default.jpg',
                        ));

                        Session::flash('success', 'Submitted Successfully.');
                        Session::delete('form_data');
                        Redirect::to($backto);
                    } catch (Exception $e) {
                        Session::flash('error', $e->getMessage());
                    }
                    break;
                case 'edit':
                    try {
                        // Send 
                        $p = $programs->get(Input::get('id'));
                        if ($p) {
                            if ($image && $p->image && $p->image != 'default.jpg') {
                                Helpers::deleteFile("../media/images/programs/" . $p->image);
                                Helpers::deleteFile("../media/images/resized/programs/" . $p->image);
                            }
                            $programs->update(array(
                                'title' => Input::get('title'),
                                'text' => nl2br(Input::get('text')),
                                'status' => Input::get('status'),
                                'image' => $image ? $image : $p->image,
                            ), Input::get('id'));

                            Session::flash('success', 'Edited Successfully.');
                            Session::delete('form_data');
                            Redirect::to($backto);
                        }
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
