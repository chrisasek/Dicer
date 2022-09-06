<?php
$user = new User();
$metas = new General('metas');
require_once('head.php');

$user->isLoggedIn() && $user->isAdmin() ? require_once('nav.php') : null;

if (!$user->isLoggedIn() && empty(Input::get('page'))) {
	Template::render('home', 'view');
} else {
	if ($user->isLoggedIn() && $user->isAdmin()) {
		!Input::get('page') ?
			Template::render('home', 'view/admin') :
			Template::render(Input::get('page'), 'view/admin');
	}
}

$user->isLoggedIn() && $user->isAdmin() ? require_once('footer.php') : null;
require_once('foot.php');
