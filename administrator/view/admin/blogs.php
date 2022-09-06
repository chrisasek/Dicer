<?php

$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$blogs = new General('blogs');

$items = $blogs->getAll();
$item = Input::get('action') && Input::get('action') == 'edit' && Input::get('sub') && is_numeric(Input::get('sub')) ? $blogs->get(Input::get('sub')) : null;

Alerts::displayError();
Alerts::displaySuccess();
?>

<?php if (Input::get('action') && Input::get('action') == 'add' || $item) { ?>
    <!-- Card Header - Dropdown -->
    <div class="d-flex flex-row align-items-center justify-content-between mb-4">
        <p class="mb-0 font-weight-bold">Add Blog </p>
        <a href="blogs<?= Input::get('sub') && Input::get('sub') == 'add' ? null : '/add'; ?>" class="btn"><i class="fas fa-plus me-2"></i> <?= Input::get('sub') && Input::get('sub') == 'add' ? 'List' : "Add"; ?></a>
    </div>

    <div class="card border-0">
        <div class="card-body">
            <form action="controllers/blogs.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-12 form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" value="<?= $item ? $item->title : null ?>" id="title" class="form-control slugit" data-slugit-target="#slug" data-slugit-event="keyup">
                    </div>
                    <div class="col-12 form-group">
                        <label for="">Context</label>
                        <input type="text" name="subtitle" value="<?= $item ? $item->subtitle : null ?>" id="subtitle" class="form-control">
                    </div>
                    <div class="col-md-4 form-group mb-4">
                        <label for="">Preview Image</label>
                        <div class="custom-file">
                            <input type="file" name="featured[]" class="custom-file-input" id="featured">
                            <label class="custom-file-label" for="featured">Choose file</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Category</label>
                        <input type="text" name="category" value="<?= $item ? $item->category : null ?>" id="category" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="">Status</label>
                        <select type="text" name="status" id="status" class="custom-select form-control">
                            <option value="public">Public</option>
                            <option value="hidden">Hidden</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">Post</label>
                        <textarea name="post" id="post" class="summernote form-control"><?= $item ? $item->text : null; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug" class="">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="link" value="<?= $item ? $item->slug : null; ?>">
                </div>
                <div class="form-group">
                    <input type="hidden" name="rq" value="<?= $item ? 'edit-blog' : 'add-blog'; ?>">
                    <input type="hidden" name="id" value="<?= $item ? $item->id : null; ?>">
                    <input type="hidden" name="token" value="<?= Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
                    <button type="submit" class="btn btn-info btn-b btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="d-flex flex-row align-items-center justify-content-between mb-4">
        <h3 class="mb-3">Blogs </h3>
        <a href="blogs<?= Input::get('sub') && Input::get('sub') == 'add' ? null : '/add'; ?>" class="btn"><i class="fa fa-plus me-2"></i> <?= Input::get('sub') && Input::get('sub') == 'add' ? 'List' : "Add"; ?></a>
    </div>

    <div class="card border-0">
        <!-- Card Header - Dropdown -->
        <!-- Card Body -->
        <div class="card-body">
            <?php if ($items) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped  dataTable-order-3" id="" data-pos="3" data-type="desc" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">Title</th>
                                <th class="">Category</th>
                                <th class="">Status</th>
                                <th class="">Date</th>
                                <th class="">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($items as $index => $con) {
                            ?>
                                <tr>
                                    <td class=""><?= $con->title; ?></td>
                                    <td class=""><?= $con->category; ?></td>
                                    <td class=""><?= $con->status ? 'public' : 'hidden'; ?></td>
                                    <td class=""><?= date('H:ia M d, y', strtotime($con->date_added)); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="blogs/edit/<?= $con->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="controllers/blogs.php?rq=status&id=<?= $con->id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="controllers/blogs.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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