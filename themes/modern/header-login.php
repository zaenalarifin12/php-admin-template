<!DOCTYPE HTML>
<html lang="en">
<title><?=$site_title?></title>
<meta name="descrition" content="<?=$site_title?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=$config['base_url'] . 'assets/images/favicon.png'?>" />
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/bootstrap/css/bootstrap.min.css'?>"/>
<link rel="stylesheet" type="text/css" href="<?=$config['base_url'] . 'assets/vendors/font-awesome/css/font-awesome.min.css'?>"/>
<link rel="stylesheet" type="text/css" href="<?=THEME_URL . 'assets/css/login.css'?>"/>
<link rel="stylesheet" type="text/css" href="<?=THEME_URL . 'assets/css/login-header.css'?>"/>
<?php
if (!empty($styles)) {
	foreach($styles as $file) {
		echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>';
	}
}
?>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/jquery/jquery-3.3.1.min.js'?>"></script>
<script type="text/javascript" src="<?=$config['base_url'] . 'assets/vendors/bootstrap/js/bootstrap.min.js'?>"></script>
<?php
if (!empty($js)) {
	foreach($js as $file) {
		echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>';
	}
}
?>
</html>
<body>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-container">
		<div class="login-header">
			<div class="logo">
				<img src="<?php echo $config['base_url'] . 'assets/images/' . $setting_web['logo_login']?>">
			</div>
			
			<?php if (!empty($desc)) {
				echo '<p>' . $desc . '</p>';
			}?>
		</div>