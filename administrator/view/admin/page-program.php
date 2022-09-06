<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$programs = new General("programs");
$msgs = $programs->getAll();

$edit = Input::get('action') && Input::get('action') == 'edit' && Input::get('sub')  && is_numeric(Input::get('sub')) ? $programs->get(Input::get('sub')) : null;

// errors
Alerts::displayError();
Alerts::displaySuccess();
?>
<!-- Card Header - Dropdown -->
<div class="d-flex flex-row align-items-center justify-content-between mb-4">
    <h3 class="">Programmes</h3>
    <a href="page-program/add" class="btn"><i class="fa fa-plus me-2"></i> Add</a>
</div>

<?php if (Input::get('action') && (Input::get('action') == 'add' || Input::get('sub') == 'edit')) { ?>
    <div class="row border-0">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary-y py-2">
                    <p class="mb-0 font-weight-bold"><?= Input::get('sub') == 'add' ? "Add" : "Edit"; ?> Program</p>
                </div>
                <div class="card-body">
                    <form action="controllers/programs.php" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="<?= $edit ? $edit->title : null; ?>" id="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="file">Image</label>
                            <input type="file" name="file[]" id="file" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="text" id="" cols="30" rows="10" class="form-control summernote"><?= $edit ? $edit->text : null; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">publish</option>
                                <option value="0">unpublish</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="token" value="<?= Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
                            <input type="hidden" name="rq" value="<?= Input::get('sub') == 'add' ? "add" : "edit"; ?>">
                            <input type="hidden" name="id" value="<?= Input::get('sub') == 'edit' ? Input::get('sub') : null; ?>">
                            <button type="submit" class="btn btn-info btn-b">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body">
            <?php if ($msgs) { ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">Title</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($msgs as $index => $con) {
                            ?>
                                <tr>
                                    <td class=""><?php echo $con->title; ?></td>
                                    <td class="text-center">
                                        <?php if ($con->status) { ?>
                                            <p><i class="fa fa-circle text-success"></i> public</p>
                                        <?php } else {
                                            echo '<p><i class="fa fa-circle text-warning"></i> hidden</p>';
                                        } ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group flex-wrap">
                                            <a href="page-program/edit/<?= $con->id; ?>" class="btn btn-info btn-b btn-sm"><i class="fa fa-edit"></i> edit</a>
                                            <a href="controllers/programs.php?rq=status&status=<?= $con->status ? 0 : 1; ?>&id=<?= $con->id; ?>" class="btn btn-<?= $con->status ? 'warning' : 'primary'; ?> btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="controllers/programs.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            <?php } else {
                echo '<p>No programs Made.</p>';
            } ?>
        </div>
    </div>
<?php } ?>