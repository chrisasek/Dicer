<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$request = new General('partners');
$msgs = $request->getAll();

// errors
Alerts::displayError();
Alerts::displaySuccess();
?>

<h3 class="mb-4">Partner Request</h3>

<div class="card border-0">
    <div class="card-body">
        <?php if ($msgs) { ?>
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="">Name</th>
                            <th class="">Phone</th>
                            <th class="">Email</th>
                            <th class="">Message</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 0;
                        foreach ($msgs as $index => $con) {
                            ++$count;
                        ?>
                            <tr>
                                <td class="text-center"><?= $count ?></td>
                                <td class=""><?php echo $con->name; ?></td>
                                <td class=""><?php echo $con->phone; ?></td>
                                <td class=""><?php echo $con->email; ?></td>
                                <td class=""><?php echo $con->message; ?></td>
                                <td class="text-center">
                                    <div class="btn-group flex-wrap">
                                        <a href="controllers/partner.php?rq=delete&id=<?= $con->id; ?>&backto=../administrator/partners" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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