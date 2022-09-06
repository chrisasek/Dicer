<?php
$user = isset($user) ? $user : new User();
$editors = new General("editors");
$about = $editors->get(1);

// errors
Alerts::displayError();
Alerts::displaySuccess();
?>


<h3 class="mb-4">Edit About Page</h3>

<div class="card border-0">
    <div class="card-body">
        <form action="controllers/editors.php" method="post">
            <div class="form-group">
                <label for="about-us">Edit</label>
                <textarea name="about-us" id="about-us" class="form-control summernote"><?= $about->text; ?></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="token" value="<?= Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
                <input type="hidden" name="rq" value="about-us">
                <button type="submit" class="btn btn-info btn-b">Submit</button>
            </div>
        </form>
    </div>
</div>