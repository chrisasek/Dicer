<?php
$user = new User();

Alerts::displaySuccess();
Alerts::displayError();
?>

<header class="navbar navbar-expand-lg navbar-light sticky-top bg-white flex-md-nowrap p-0">
	<a class="navbar-brand bg-white col-md-3 col-lg-2 me-0 px-3 fs-6" href="">
		<img src="<?= SITE_URL; ?>media/images/logo.png" alt="" class="img-fluid" style="height: 65px;">
	</a>
	<button class="navbar-toggler position-absolute d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="col-lg-2 d-none d-lg-block me-auto">
		<input class="form-control" type="text" placeholder="Search . . ." aria-label="Search . . .">
	</div>

	<div class="navbar-nav d-none d-lg-block">
		<div class="nav-item text-nowrap">
			<a class="nav-link text-danger fw-bold px-3" href="controllers/logout.php"><i class="me-2 fa fa-sign-out-alt"></i> Sign out</a>
		</div>
	</div>
</header>

<div class="container-fluid">
	<div class="row">
		<nav id="sidebarMenu" class="col-lg-2 d-lg-block sidebar collapse">
			<div class="position-sticky pt-3">
				<ul class="nav flex-column">
					<li class="nav-item <?= !Input::get('page') ? 'active' : null; ?>">
						<a href="" class="nav-link"><i class="me-2 fas fa-bars"></i> Dashboard</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'blogs' ? 'active' : null; ?>">
						<a href="blogs" class="nav-link"><i class="me-2 fas fa-list"></i> Blogs</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'partners' ? 'active' : null; ?>">
						<a href="partners" class="nav-link"><i class="me-2 fas fa-user-plus"></i> Partners</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'profile' ? 'active' : null; ?>">
						<a href="profile" class="nav-link"><i class="me-2 fas fa-user-edit"></i> Profile</a>
					</li>

					<?php if ($user->data()->group > 2) { ?>
						<li class="nav-item  <?= Input::get('page') && Input::get('page') == 'users' ? 'active' : null; ?>">
							<a href="users" class="nav-link"><i class="me-2 fas fa-user-cog"></i> Admin</a>
						</li>
					<?php } ?>
				</ul>

				<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-4 text-muted text-uppercase">
					<span>Pages</span>
				</h6>
				<ul class="nav flex-column mb-2">
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'page-about-us' ? 'active' : null; ?>">
						<a class="nav-link" href="page-about-us">About Us</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'page-program' ? 'active' : null; ?>">
						<a class="nav-link" href="page-program">Programs</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'teams' ? 'active' : null; ?>">
						<a class="nav-link" href="teams">Teams</a>
					</li>
					<li class="nav-item <?= Input::get('page') && Input::get('page') == 'gallery' ? 'active' : null; ?>">
						<a class="nav-link" href="gallery">Gallery</a>
					</li>
				</ul>

				<ul class="nav flex-column mb-2 d-lg-none">
					<li class="nav-item">
						<a class="nav-link text-danger" href="gallery"><i class="me-2 fa fa-sign-out-alt"></i> Sign Out</a>
					</li>
				</ul>

			</div>
		</nav>

		<main class="col-lg-9 ms-sm-auto col-lg-10 my-5">
			<div class="content-container py-5 px-3 px-md-4 px-lg-5">