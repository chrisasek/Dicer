<?php
$user = isset($user) ? $user : new User();
$user->isLoggedIn() ? Redirect::to('../') : null;

Alerts::displayError();
Alerts::displaySuccess();
?>

<section class="container-fluid" style="background: #fff9e2;">
	<section class="container">
		<div class="row min-vh-100 align-items-center justify-content-center">
			<section class="col-lg-5">
				<div class="card border-0 shadow-sm py-4 p-lg-4">
					<div class="card-body">
						<div class="text-center mb-4">
							<img src="<?= SITE_URL; ?>media/images/logo.png" alt="" class="img-fluid mb-3" style="height: 80px;">
							<p class="mb-0 text-muted">Administrator Access</p>
						</div>
						<form class="" action="controllers/login.php" method="post">
							<div class="mb-4">
								<label for="email" class="mb-2">Email</label>
								<input type="email" name="email" class="form-control form-control-lg" id="email" aria-describedby="email" placeholder="johndoe@client.com" autocomplete="new-password" required>
							</div>
							<div class="mb-3">
								<label for="password" class="mb-2">Password</label>
								<input type="password" name="password" class="form-control form-control-lg" autocomplete="new-password" id="password" placeholder="Enter Password" required>
							</div>
							<div class="form-group form-check mb-4">
								<input type="checkbox" class="form-check-input" name="remember" id="remember" checked>
								<label class="form-check-label" for="remember">Remember Me</label>
							</div>
							<div>
								<input type="hidden" name="token" value="<?php echo Session::exists('token') ? Session::get('token') : Token::generate(); ?>">
								<input type="hidden" name="type" value="admin">
								<button type="submit" class="btn w-100" style="font-size: 14px; font-weight:bold; background: #fdd741; padding: .8rem 2rem;">Sign In</button>
							</div>

						</form>
					</div>
				</div>
			</section>
		</div>
	</section>
</section>