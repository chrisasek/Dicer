<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$user->data()->group > 2 ? null : Redirect::to_js('administrator/home');

$msgs = $user->getAll();
$con = Input::get('action') && Input::get('action') == 'update' && Input::get('sub') ? $user->get(Input::get('sub')) : null;
$details = $con ? json_decode($con->details) : null;

Alerts::displayError();
Alerts::displaySuccess();
?>


<?php if (Input::get('action') && Input::get('action') == 'add') { ?>
  <!-- Card Header - Dropdown -->
  <div class="d-flex flex-row align-items-center justify-content-between mb-4">
    <h3 class="">New User</h3>
    <a href="users<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class=""><i class="fas fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
  </div>

  <div class="card border-0">
    <!-- Card Body -->
    <div class="card-body">
      <form action="controllers/user.php" method="post">
        <div class="form-row">
          <div class="col-md-12 form-group mb-3">
            <label for="Full name">Full Name</label>
            <input type="text" name="fullname" class="form-control" id="fullname" aria-describedby="name" placeholder="Name" autocomplete="new-name" required>
          </div>
          <div class="col-md-6 form-group mb-3">
            <label for="Full name">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" aria-describedby="phone" placeholder="Phone" autocomplete="new-phone" required>
          </div>
          <div class="col-md-6 form-group mb-3">
            <label for="Full name">Email</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="email" placeholder="Email" autocomplete="new-email" required>
          </div>
          <div class="col-md-6 form-group">
            <label for="year">Enter Username</label>
            <input type="text" name="username" id="usernme" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label for="year">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>
        </div>
        <div class="form-group mt-3">
          <input type="hidden" name="rq" value="<?= Input::get('action') && Input::get('action') == 'update' && Input::get('sub') ? 'update-admin' : 'add-admin' ?>">
          <input type="hidden" name="id" value="<?= $id; ?>">
          <input type="hidden" name="token" id="token" value="<?= Session::exists('token') ? Session::get('token') : Token::generate() ?>">
          <button type="submit" class="btn btn-info btn-b"><?= Input::get('action') && Input::get('action') == 'update' && Input::get('sub') ? 'Update' : 'Add' ?></button>
        </div>
      </form>
    </div>
  </div>
<?php } else { ?>
  <!-- Card Header - Dropdown -->
  <div class="d-flex flex-row align-items-center justify-content-between mb-4">
    <h3 class="">Administrators</h3>
    <a href="users<?= Input::get('action') && Input::get('action') == 'add' ? null : '/add'; ?>" class="btn"><i class="fas fa-plus me-2"></i> <?= Input::get('action') && Input::get('action') == 'add' ? 'List' : "Add"; ?></a>
  </div>

  <div class="card border-0">
    <div class="card-body">
      <?php if ($msgs) { ?>
        <div class="table-responsive">
          <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="">Name</th>
                <th class="">Username</th>
                <th class="">Email</th>
                <th class="">Phone</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>

              <?php
              foreach ($msgs as $index => $con) {
                if ($con->group == 1 || $user->data()->id == $con->id) continue;
              ?>
                <tr>
                  <td class=""><?php echo $con->name; ?></td>
                  <td class=""><?php echo $con->username; ?></td>
                  <td class=""><?php echo $con->email; ?></td>
                  <td class=""><?php echo $con->phone; ?></td>
                  <td class="text-center">
                    <a href="controllers/user.php?rq=delete&id=<?= $con->id; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      <?php } else {
        echo '<p>No Fee Made.</p>';
      } ?>
    </div>
  </div>
<?php } ?>