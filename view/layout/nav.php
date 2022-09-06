<?php
$User = new User();
?>
<div id="oniontabs-top-nav" class="bg-white">
	<nav class="container navbar navbar-expand-lg navbar-light text-uppercase">
		<a href="<?= SITE_URL ?>" class="navbar-brand"><img src="media/images/logo.png" height="80" alt="Network of Probono Lawyers" class="d-inline-block align-top"></a>
		<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbar7">
			<span class="navbar-toggler-icon text-white"></span>
		</button>
		<div class="navbar-collapse collapse justify-content-stretch" id="navbar7">
			<ul class="navbar-nav ml-auto align-items-md-center">
				<li class="nav-item">
					<a class="nav-link mr-md-2 <?= !Input::get('page') || Input::get('page') == 'home' ? 'active' : null; ?>" href="">HOME <span class="sr-only">HOME</span></a>
				</li>
				<li class="nav-item ">
					<a class="nav-link mr-md-2 <?= Input::get('page') && Input::get('page') == 'about-us' ? 'active' : null; ?>" href="about-us">ABOUT US</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link mr-md-2 <?= Input::get('page') && Input::get('page') == 'our-programs' ? 'active' : null; ?>" href="our-programs">OUR PROGRAMS</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link mr-md-2 <?= Input::get('page') && Input::get('page') == 'contact-us' ? 'active' : null; ?>" href="contact-us">CONTACT US</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link mr-md-4 <?= Input::get('page') && Input::get('page') == 'blog' ? 'active' : null; ?>" href="blog">BLOG</a>
				</li>

				<?php
				if ($User->isLoggedIn() && $User->isAdmin()) { ?>
					<li class="nav-item ">
						<a class="nav-link <?= Input::get('page') && Input::get('page') == 'home' ? 'active' : null; ?>" href="administrator">DASHBOARD</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link btn bg-primary-y shadow text-danger" href="controllers/logout.php">Log<i class="fa fa-power-off"></i>ut</a>
					</li>
				<?php } else { ?>
					<li class="nav-item ml-md-3 mt-4 mt-md-0">
						<a class="nav-link btn bg-primary-y shadow text-dark font-weight-bold px-3" href="make-a-report">Make A Report</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</nav>
</div>

<?php
Alerts::displaySuccess();
Alerts::displayError();
?>