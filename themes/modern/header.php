<?php 
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

global $app_module;
global $js;
global $styles;
global $app_layout;
global $setting_web;
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?=$app_module['judul_module']?> | <?=$setting_web['judul_web']?></title>
<meta name="descrition" content="<?=$app_module['deskripsi']?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=$config['base_url'] . 'assets/images/favicon.png'?>" />
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/font-awesome/css/all.css'?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/bootstrap/css/bootstrap.min.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/iconpicker/css/bulma-iconpicker.min.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=THEME_URL . 'assets/css/bootstrap-custom.css?r=' . time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/sweetalert2/sweetalert2.min.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/sweetalert2/sweetalert2.custom.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/overlayscrollbars/OverlayScrollbars.min.css?r='.time()?>"/>
<link rel="stylesheet" type="text/css" href="<?=THEME_URL . 'assets/css/site.css?r='.time()?>"/>

<link rel="stylesheet" id="style-switch" type="text/css" href="<?=THEME_URL . 'assets/css/color-schemes/'.$app_layout['color_scheme'].'.css?r='.time()?>"/>
<link rel="stylesheet" id="style-switch-sidebar" type="text/css" href="<?=THEME_URL . 'assets/css/color-schemes/'.$app_layout['sidebar_color'].'-sidebar.css?r='.time()?>"/>
<link rel="stylesheet" id="font-switch" type="text/css" href="<?=THEME_URL . 'assets/css/fonts/'.$app_layout['font_family'].'.css?r='.time()?>"/>
<link rel="stylesheet" id="font-size-switch" type="text/css" href="<?=THEME_URL . 'assets/css/fonts/font-size-'.$app_layout['font_size'].'.css?r='.time()?>"/>
<link rel="stylesheet" id="logo-background-color-switch" type="text/css" href="<?=THEME_URL . 'assets/css/color-schemes/'.$app_layout['logo_background_color'].'-logo-background.css?r='.time()?>"/>
<?php
if (@$styles) {
	foreach($styles as $file) {
		echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>';
	}
}
?>
<script type="text/javascript">
	var base_url = "<?=$config['base_url']?>";
	var module_url = "<?=module_url()?>";
	var current_url = "<?=current_url()?>";
	var theme_url = "<?=theme_url()?>";
</script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/jquery/jquery-3.4.1.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/bootstrap/js/bootstrap.min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/bootbox/bootbox.min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/zenscroll/zenscroll-min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/iconpicker/js/bulma-iconpicker.min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/sweetalert2/sweetalert2.min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/overlayscrollbars/jquery.overlayScrollbars.min.js'?>"></script>
<script type="text/javascript" src="<?=THEME_URL . 'assets/js/site.js?r='.time()?>"></script>
<?php
if (@$js) {
	foreach($js as $file) {
		echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>';
	}
}

$user = $_SESSION['user'];

?>
</head>
<body>
	<header class="nav-header">
		<div class="nav-header-logo pull-left">
			<a class="header-logo" href="<?=$config['base_url']?>" title="Jagowebdev">
				<img src="<?=BASE_URL . $config['images_path'] . $setting_web['logo_app']?>"/>
			</a>
		</div>
		<div class="pull-left nav-header-left">
			<ul class="nav-header">
				<li>
					<a href="#" id="mobile-menu-btn">
						<i class="fa fa-bars"></i>
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right mobile-menu-btn-right">
			<a href="#" id="mobile-menu-btn-right">
				<i class="fa fa-ellipsis-h"></i>
			</a>
		</div>
		<div class="pull-right nav-header nav-header-right">
			
			<ul>
				<li><a class="icon-link" href="<?=$config['base_url']?>setting"><i class="fas fa-cog"></i></a></li>
				
				<li>
					<?php $img_url = !empty($user['avatar']) ? $config['base_url'] . $config['user_images_path'] . $user['avatar'] : $config['base_url'] . $config['user_images_path'] . 'default.png';
					$account_link = $config['base_url'] . 'user';
					?>
					<a class="profile-btn" href="<?=$account_link?>"><img src="<?=$img_url?>" alt="user_img"></a>
					<div class="account-menu-container">
						<?php
						if ($is_loggedin) { 
							?>
							<ul class="account-menu">
								<li class="account-img-profile">
									<div class="avatar-profile">
										<img src="<?=$img_url?>" alt="user_img">
									</div>
									<div class="card-content">
									<p><?=strtoupper($user['nama'])?></p>
									<p><small>Email: <?=$user['email']?></small></p>
									</div>
								</li>
								<li><a href="<?=$config['base_url']?>user?action=edit-password&id=<?=$user['id_user']?>">Change Password</a></li>
								<li><a href="<?=$config['base_url']?>login?action=logout">Logout</a></li>
							</ul>
						<?php } else { ?>
							<div class="float-login">
							<form method="post" action="<?=$config['base_url']?>login">
								<input type="email" name="email" value="" placeholder="Email" required>
								<input type="password" name="password" value="" placeholder="Password" required>
								<div class="checkbox">
									<label style="font-weight:normal"><input name="remember" value="1" type="checkbox">&nbsp;&nbsp;Remember me</label>
								</div>
								<button type="submit"  style="width:100%" class="btn btn-success" name="submit">Submit</button>
								<?php
								$form_token = $auth->generateFormToken('login_form_token_header');
								?>
								<input type="hidden" name="form_token" value="<?=$form_token?>"/>
								<input type="hidden" name="login_form_header" value="login_form_header"/>
							</form>
							<a href="<?=$config['base_url'] . 'recovery'?>">Lupa password?</a>
							</div>
						<?php }?>
					</div>
				</li>
			</ul>
		
		</div>
	</header>
	<div class="site-content">
		<?php
		require_once('includes/functions.php');
		
		// MENU - SIDEBAR
		$menu_db = get_menu_db(1);
		$list_menu = menu_list($menu_db);
		// echo '<pre>'; print_r($menu_db);
		?>
		<div class="sidebar">
			<nav>
			<?php
			echo build_menu($list_menu);
			?>
			</nav>
		</div>
		<div class="content">
		<?=!empty($breadcrumb) ? breadcrumb($breadcrumb) : ''?>
		<div class="content-wrapper">
		