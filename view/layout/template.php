<?php 
$user = new User();
$metas = new General('metas');
require_once('head.php');
require_once('nav.php');

	if(empty(Input::get('page'))){
		Template::render('home', 'view');
	}else{
		if(Input::get('page') && Input::get('page') == 'administrator' && Input::get('action')){
			$user->isLoggedIn() && $user->isAdmin() ? Template::render('home', 'view/admin') : Template::render('home', 'view');
		}else{
			Input::get('page') && Input::get('page') == 'administrator' && $user->isLoggedIn() && $user->isAdmin() ? Template::render('home', 'view/admin') :Template::render(Input::get('page'), 'view');
		}
	}
require_once('footer.php');
require_once('foot.php');
?>