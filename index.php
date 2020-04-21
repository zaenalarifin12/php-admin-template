<?php
/** ERROR HANDLER */
include 'system/error_handler.php';
include 'config/constant.php';

if (ENVIRONMENT == 'production') {
	error_reporting( 0 );
} else {
	error_reporting( E_ALL );
}

session_start();
include 'config/config.php';
include 'config/database.php';
include 'includes/functions.php';
include 'system/functions.php';
include 'libraries/database/'.strtolower($database['driver']).'.php';
include 'libraries/auth.php';

define ('BASE_URL', $config['base_url']);
define ('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define ('THEME_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'themes/' . $config['theme'] . '/');
define ('THEME_URL', $config['base_url'] . 'themes/' . $config['theme'] . '/');

$app_auth = new Auth();
$db = new Database();

// Token for lofin form
$is_loggedin = $app_auth->isLoggedIn();
if (!$is_loggedin) {
	$form_token = $app_auth->generateFormToken();
}

// Module
$default_module = $config['default_module'];
if ($is_loggedin) {
	$query = $db->query('SELECT nama_module 
					FROM role 
					LEFT JOIN module USING(id_module)
					WHERE id_role = ? '
					, $_SESSION['user']['id_role']
				)->row();
	$default_module = $query['nama_module'];
}
// echo $default_module['nama_module']; die;				
$nama_module = !empty($_GET['module']) ? $_GET['module'] : $default_module;


// Module Detail
$app_module = $db->query('SELECT * FROM module WHERE nama_module = ? ', $nama_module)->row();
if (!$app_module) {
	echo 'Module tidak ditemukan di database'; die;
}

// Setting logo
$sql = 'SELECT * FROM setting_web';
$query = $db->query($sql)->result();
foreach($query as $val) {
	$setting_web[$val['param']] = $val['value'];
}

// Setting tampilan
if ($is_loggedin){
	$user_setting = $db->query('SELECT * FROM setting_app_user WHERE id_user = ?', $_SESSION['user']['id_user'])
						->row();
	if ($user_setting) {
		$app_layout = json_decode($user_setting['param'], true);
		// print_r($layout); die;
	} else {
		$query = $db->query('SELECT * FROM setting_app_tampilan')->result();
		foreach ($query as $val) {
			$app_layout[$val['param']] = $val['value'];
		}
	}
}

// Breadcrumb
$breadcrumb = [];
$breadcrumb['Home'] = $config['base_url'];
$breadcrumb[$app_module['judul_module']] = module_url();

$query = $db->query('SELECT * FROM module_role WHERE id_module = ? ', $app_module['id_module'])->result();
// echo '<pre>'; print_r($query); die;
$module_role = [];
foreach ($query as $val) {
	$module_role[$val['id_role']] = $val;
}

$list_action = [];
if ($is_loggedin && $app_module['nama_module'] != 'login') {
	
	if ($module_role) {
		if (key_exists($_SESSION['user']['id_role'], $module_role)) {
			$list_action = $module_role[$_SESSION['user']['id_role']];
		}
		if ($app_module['nama_module'] != 'login' ) {
			// echo '<pre>'; print_r($module_role); die;
			if (!key_exists($_SESSION['user']['id_role'], $module_role)) {
				// echo 'Anda tidak diperbolehkan mengakses halaman ' . $app_module['judul_module']; die;
				$app_module['nama_module'] = 'error';
				load_view('views/error.php', ['status' => 'error', 'message' => 'Anda tidak berhak mengakses halaman ini']);
			}
		}
	} else {
		$app_module['nama_module'] = 'error';
		load_view('views/error.php', ['status' => 'error', 'message' => 'Role untuk module ini belum diatur']);
	}
}

if ($app_module) {
	
	if ($app_module['id_module_status'] == 3) {
		exit_error('Module tidak aktif');
	} elseif ($app_module['id_module_status'] == 2) {
		exit_error('Module dalam pengembangan. Hanya user dengan Role Developer yang dapat mengakses halaman ini');
	}
	
	$module_file = 'modules/' . $app_module['nama_module'] . '/' . $app_module['nama_module'] . '.php';
	
	if (file_exists($module_file)) 
	{
		if (empty($_GET['action'])) {
			$_GET['action'] = 'index';
		}
		
		//if (check_module_role()) {
			//exit_error('Module belum di definisikan di database');
		//}
		include( $module_file ); 
	} else {
		$content = 'File module tidak ditemukan...';
		exit_error($content);
	}
	
} else {
	exit_error('Module <strong>' . $nama_module . '</strong> tidak terdaftar di database');
}