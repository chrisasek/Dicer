<?php

$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$teams = new General('teams');

$items = $teams->getAll();
$item = Input::get('action') && Input::get('action') == 'edit' && Input::get('sub') && is_numeric(Input::get('sub')) ? $teams->get(Input::get('sub')) : null;

// errors
Alerts::displayError();
Alerts::displaySuccess();
?>


<?php if (Input::get('action') && Input::get('action') == 'add' || $item) { ?>
    <div class="d-flex flex-row align-items-center justify-content-between mb-4">
        <h3 class="">Manage Team </h3>
        <a href="teams<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class="btn"><i class="fas fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
    </div>

    <div class="card border-0">
        <!-- Card Body -->
        <div class="card-body">
            <div class="col-md-12 mx-auto card p-3 border-0">
                <form action="controllers/teams.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="<?= $item ? $item->name : null ?>" id="name" class="form-control slugit" data-slugit-target="#slug" data-slugit-event="keyup">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="position">Position</label>
                            <input type="text" name="position" value="<?= $item ? $item->position : null ?>" id="position" class="form-control">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="">Preview Image</label>
                            <div class="custom-file">
                                <input type="file" name="featured[]" class="custom-file-input" id="featured">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="profile">Profile</label>
                            <textarea name="profile" id="profile" class="summernote form-control"><?= $item ? $item->profile : null; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <input type="hidden" name="slug" id="slug">
                        <input type="hidden" name="rq" value="<?= $item ? 'edit' : 'add'; ?>">
                        <input type="hidden" name="id" value="<?= $item ? $item->id : null; ?>">
                        <input type="hidden" name="token" value="<?= Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
                        <button type="submit" class="btn btn-info btn-b btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="d-flex flex-row align-items-center justify-content-between mb-4">
        <h3 class="">Teams </h3>
        <a href="teams<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class="btn"><i class="fa fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
    </div>

    <div class="card border-0">
        <div class="card-body">
            <?php if ($items) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped  dataTable-order-3" id="" data-pos="3" data-type="desc" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">/</th>
                                <th class="">Name</th>
                                <th class="">Position</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $count = 0;
                            foreach ($items as $index => $con) {
                                ++$count;
                            ?>
                                <tr>
                                    <td class=""><?= $count; ?></td>
                                    <td class=""><?= $con->name; ?></td>
                                    <td class=""><?= $con->position; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="teams/edit/<?= $con->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="controllers/teams.php?rq=status&id=<?= $con->id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="controllers/teams.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            <?php } else {
                echo '<p>No items found.</p>';
            } ?>
        </div>
    </div>
<?php } ?>