<?php

$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$gallery = new General('gallery');

$items = $gallery->getAll();
$item = Input::get('action') && Input::get('action') == 'edit' && Input::get('sub') && is_numeric(Input::get('sub')) ? $gallery->get(Input::get('sub')) : null;

// errors
Alerts::displayError();
Alerts::displaySuccess();
?>
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <!-- List -->
        <div class="col-md-12 mx-auto">
            <?php if (Input::get('action') && Input::get('action') == 'add' || $item) { ?>
                <!-- Card Header - Dropdown -->
                <div class="d-flex flex-row align-items-center justify-content-between mb-4">
                    <p class="mb-0 font-weight-bold">Manage (Add/Edit) Gallery </p>
                    <a href="gallery<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class="btn"><i class="fas fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
                </div>

                <div class="card border-0">
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="col-md-12 mx-auto card p-3 border-0">
                            <form action="controllers/gallery.php" method="post" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="col-md-4 form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" value="<?= $item ? $item->title : null ?>" id="title" class="form-control slugit" data-slugit-target="#slug" data-slugit-event="keyup">
                                    </div>
                                    <div class="col-md-4 form-group mb-4">
                                        <label for="">Preview Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="featured[]" class="custom-file-input" id="featured">
                                            <label class="custom-file-label" for="featured">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="">Status</label>
                                        <select type="text" name="status" id="status" class="custom-select form-control">
                                            <option value="public">Public</option>
                                            <option value="hidden">Hidden</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="summernote form-control"><?= $item ? $item->description : null; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="slug" name="slug">
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
                <!-- Card Header - Dropdown -->
                <div class="d-flex flex-row align-items-center justify-content-between mb-4">
                    <p class="mb-0 font-weight-bold">Gallery </p>
                    <a href="gallery<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class="btn"><i class="fas fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
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
                                            <th class="">Title</th>
                                            <th class="">Status</th>
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
                                                <td class=""><?= $con->title; ?></td>
                                                <td class=""><?= $con->status ? 'public' : 'hidden'; ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="gallery/edit/<?= $con->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="controllers/gallery.php?rq=status&id=<?= $con->id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                                        <a href="controllers/gallery.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
        </div>

    </div>
</div>
<!-- /.container-fluid -->