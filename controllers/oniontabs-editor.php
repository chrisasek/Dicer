<?php
require_once("../core/init.php");
if ($_FILES && $_FILES['image']['name']) {
    if (!$_FILES['image']['error']) {
        $name = Helpers::getUnique(5, 3);
        $ext = explode('.', $_FILES['image']['name']);
        $filename = $name . '.' . $ext[1];
        $destination = SITE_ROOT . '/media/images/blog/editor/' . $filename; //change this directory
        $location = $_FILES["image"]["tmp_name"];
        move_uploaded_file($location, $destination);
        $path = 'media/images/blog/editor/';
        echo  $path . $filename; //change this URL
    } else {
        echo  $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['image']['error'];
    }
}
