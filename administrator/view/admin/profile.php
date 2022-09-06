  <?php
  $user = isset($user) ? $user : new User();
  $user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
  $msgs = $user->getAll();
  // errors
  Alerts::displayError();
  Alerts::displaySuccess();
  ?>

  <h3 class="mb-4">Profile Update</h3>

  <div class="card border-0">
    <div class="card-body">
      <form class="" action="controllers/user.php" method="post">
        <h6 class="heading-small text-muted mb-4">User information</h6>
        <div class="pl-lg-4">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-username">Username</label>
                <input type="text" id="input-username" class="form-control" value="<?php echo isset($user) ? $user->data()->username : null; ?>" disabled>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-email">Email address</label>
                <input type="email" id="input-email" class="form-control form-control-alternative" value="<?php echo isset($user) ? $user->data()->email : null; ?>" disabled>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-email">Name</label>
                <input type="text" name="fullname" id="fullname" class="form-control form-control-alternative" value="<?php echo isset($user) ? $user->data()->name : null; ?>">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label" for="input-email">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control form-control-alternative" value="<?php echo isset($user) ? $user->data()->phone : null; ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- Password -->
        <h6 class="mt-3 heading-small text-muted mb-4">Change Password? <a href="" id="toggler" data-toggle="password">Click Here</a></h6>
        <div class="row pl-lg-4 d-none" id="password">
          <div class="col-md-12">
            <div class="form-group">
              <label class="form-control-label" for="input-bank-name">New Password</label>
              <input id="pass" class="form-control form-control-alternative" name="newpassword" placeholder="" type="password">
            </div>
          </div>
        </div>

        <div class="form-group">
          <input type="hidden" name="rq" value="update-admin">
          <input type="hidden" name="id" value="<?= $user->data()->id; ?>">
          <input type="hidden" name="token" value="<?php echo Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
          <button type="submit" class="btn btn-info btn-b">Update</button>
        </div>
      </form>
    </div>
  </div>