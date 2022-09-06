<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() && $user->isAdmin() ? null : Redirect::to_js('home');
$requests = new General('requests');
$blogs = new General('blogs');
$programs = new General('programs');
$partners = new General('partners');

$request_list = $requests->getAll();
$blog_count = $blogs->getCount();
$program_count = $programs->getCount();
$partner_count = $partners->getCount();

Alerts::displayError();
Alerts::displaySuccess();
?>


<div class="row gy-3 gx-lg-5 mb-5">
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center px-3">
          <h1 class="display-3 fw-bold text-accent"><?= count($request_list); ?></h1>
          <div class="ms-4">
            <span class="small text-muted mb-0">Total</span>
            <p class="fs-4 mb-0 text-accent">Requests</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center px-3">
          <h1 class="display-3 fw-bold text-primary"><?= $program_count; ?></h1>
          <div class="ms-4">
            <span class="small text-muted mb-0">Total</span>
            <p class="fs-4 mb-0 text-primary">Programmes</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center px-3">
          <h1 class="display-3 fw-bold text-green"><?= $partner_count; ?></h1>
          <div class="ms-4">
            <span class="small text-muted mb-0">Request</span>
            <p class="fs-4 mb-0 text-green">Partners</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<h3 class="mb-4">Requests</h3>

<div class="card border-0">
  <!-- Card Body -->
  <div class="card-body">
    <?php if ($request_list) { ?>
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
            foreach ($request_list as $index => $con) {
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
                    <a href="report-request/view/<?= $con->id; ?>" class="btn"><i class="fa fa-eye"></i> view</a>
                    <a href="controllers/request.php?rq=delete&id=<?= $con->id; ?>" class="btn text-danger"><i class="fa fa-trash"></i></a>
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