<?php

login_restricted();

$site_title = 'Login Into Your Account';
include 'functions.php';

switch ($_GET['action']) 
{
	default:
		action_notfound();
		
	case 'logout':
		
		delete_auth_cookie($_SESSION['user']['id_user']);
		setcookie('remember', '', -1, '/');
		session_destroy();
		header('location:'. BASE_URL); 
		
	case 'index' :

		if (isset($_POST['submit'])) 
		{
			$message = check_login();
		}
		
		global $config;
		global $site_title;
		// Theme header
		include THEME_PATH . 'header-login.php';

		include 'views/form.php';
		include THEME_PATH . 'footer-login.php';
}