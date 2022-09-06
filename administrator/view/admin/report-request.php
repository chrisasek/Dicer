<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('../home');
$request = new General('requests');
$msgs = $request->getAll();
$item = Input::get('action') && Input::get('action') == 'view' && Input::get('sub') && is_numeric(Input::get('sub')) ? $request->get(Input::get('sub')) : null;

Alerts::displayError();
Alerts::displaySuccess();
?>

<?php if ($item) { ?>
    <h3 class="mb-4">Report Request</h3>

    <div class="card">
        <div class="card-body text-center">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Name</p>
                            <p class="mb-0"><?php echo $item->name; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Phone</p>
                            <p class="mb-0"><?php echo $item->phone; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Address</p>
                            <p class="mb-0"><?php echo $item->address; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Summary</p>
                            <p class="mb-0"><?php echo $item->summary ? $item->summary : 'nil'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Prison</p>
                            <p class="mb-0"><?php echo $item->prison ? $item->prison : 'nil'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Location</p>
                            <p class="mb-0"><?php echo $item->location ? $item->location : 'nil'; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Status</p>
                            <p class="mb-0">
                                <?php
                                if ($item->status == 'pending') { ?>
                                    <i class="fa fa-circle text-warning"></i> pending
                                <?php } elseif ($item->status == 'accepted') { ?>
                                    <i class="fa fa-circle text-info"></i> accepted
                                <?php } elseif ($item->status == 'completed') { ?>
                                    <i class="fa fa-circle text-success"></i> completed
                                <?php  } elseif ($item->status == 'rejected') { ?>
                                    <i class="fa fa-circle text-danger"></i> rejected
                                <?php } else {
                                    echo '<i class="fa fa-circle text-warning"></i> pending';
                                } ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <p class="mb-0 small font-weight-bold">Date</p>
                            <p class="mb-0"><?php echo $item->date_added; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <p class="small font-weight-bold">Change Status</p>
                    <a href="controllers/request.php?rq=status&status=pending&id=<?= $item->id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-ruler-horizontal"></i> Pending</a>
                    <a href="controllers/request.php?rq=status&status=rejected&id=<?= $item->id; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-ruler-horizontal"></i> Rejected</a>
                    <a href="controllers/request.php?rq=status&status=accepted&id=<?= $item->id; ?>" class="btn btn-info btn-sm"><i class="fa fa-ruler-horizontal"></i> Accepted</a>
                    <a href="controllers/request.php?rq=status&status=completed&id=<?= $item->id; ?>" class="btn btn-success btn-sm"><i class="fa fa-ruler-horizontal"></i> Completed</a>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <h3 class="mb-4">Report Request</h3>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if ($msgs) { ?>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">Name</th>
                                <th class="">Phone</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($msgs as $index => $con) {
                            ?>
                                <tr>
                                    <td class=""><?php echo $con->name; ?></td>
                                    <td class=""><?php echo $con->phone; ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($con->status == 'pending') { ?>
                                            <p><i class="fa fa-circle text-warning"></i> pending</p>
                                        <?php } elseif ($con->status == 'accepted') { ?>
                                            <p><i class="fa fa-circle text-info"></i> accepted</p>
                                        <?php } elseif ($con->status == 'completed') { ?>
                                            <p><i class="fa fa-circle text-success"></i> completed</p>
                                        <?php  } elseif ($con->status == 'rejected') { ?>
                                            <p><i class="fa fa-circle text-danger"></i> rejected</p>
                                        <?php } else {
                                            echo '<p><i class="fa fa-circle text-warning"></i> pending</p>';
                                        } ?>
                                    </td>

                                    <td class="text-center"><?php echo $con->date_added; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group flex-wrap">
                                            <a href="report-request/view/<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-eye"></i> view</a>
                                            <a href="controllers/request.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            <?php } else {
                echo '<p>No Request Made.</p>';
            } ?>
        </div>
    </div>
<?php } ?>