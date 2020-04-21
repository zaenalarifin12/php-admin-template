<?php
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

login_required();
$js[] = BASE_URL . 'assets/vendors/spectrum/spectrum.min.js';
$js[] = BASE_URL . 'themes/modern/assets/js/setting-logo.js';
$styles[] = BASE_URL . 'assets/vendors/spectrum/spectrum.css';

switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':

		if (!empty($_POST['submit'])) 
		{
			if ($module_role[$_SESSION['user']['id_role']]['update_data'] == 'all')
			{
				$form_errors = validate_form();
				
				$sql = 'SELECT * FROM setting_web';
				$query = $db->query($sql)->result();
				foreach($query as $val) {
					$curr_db[$val['param']] = $val['value'];
				}
		
				if (!$_FILES['logo_app']['name']) {
					if ($curr_db['logo_app'] == '') {
						$form_errors['logo_app'] = 'Logo aplikasi belum dipilih';
					}
				} 
				
				if ($form_errors) {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = $form_errors;
				} else {
					// Logo Login
					$logo_login = $curr_db['logo_login'];
					$path = $config['images_path'];
					if ($_FILES['logo_login']['name']) 
					{
						//old file
						if ($curr_db['logo_login']) {
							if (file_exists($path . $curr_db['logo_login'])) {
								$unlink = unlink($path . $curr_db['logo_login']);
								if (!$unlink) {
									$data['msg']['status'] = 'error';
									$data['msg']['content'] = 'Gagal menghapus gambar lama';
								}
							}
						}
						
						$logo_login = upload_file($path, $_FILES['logo_login']);
					}
					
					// Logo App
					$logo_app = $curr_db['logo_app'];
					if ($_FILES['logo_app']['name']) 
					{
						//old file
						if ($curr_db['logo_app']) {
							if (file_exists($path . $curr_db['logo_app'])) {
								$unlink = unlink($path . $curr_db['logo_app']);
								if (!$unlink) {
									$data['msg']['status'] = 'error';
									$data['msg']['content'] = 'Gagal menghapus gambar lama';
								}
							}
						}
						
						$logo_app = upload_file($path, $_FILES['logo_app']);
					}
					
					// Favicon
					$favicon = $curr_db['favicon'];
					if ($_FILES['favicon']['name']) 
					{
						//old file
						if ($curr_db['favicon']) {
							if (file_exists($path . $curr_db['favicon'])) {
								$unlink = unlink($path . $curr_db['favicon']);
								if (!$unlink) {
									$data['msg']['status'] = 'error';
									$data['msg']['content'] = 'Gagal menghapus gambar lama';
								}
							}
						}
						
						$favicon = upload_file($path, $_FILES['favicon']);
					}
					
					if ($logo_login && $logo_app && $favicon) 
					{
						$data_db[] = ['param' => 'logo_login', 'value' => $logo_login];
						$data_db[] = ['param' => 'logo_app', 'value' => $logo_app];
						$data_db[] = ['param' => 'footer_login', 'value' => $_POST['footer_login']];
						$data_db[] = ['param' => 'btn_login', 'value' => $_POST['btn_login']];
						$data_db[] = ['param' => 'footer_app', 'value' => $_POST['footer_app']];
						$data_db[] = ['param' => 'background_logo', 'value' => $_POST['background_logo']];
						$data_db[] = ['param' => 'judul_web', 'value' => $_POST['judul_web']];
						$data_db[] = ['param' => 'deskripsi_web', 'value' => $_POST['deskripsi_web']];
						$data_db[] = ['param' => 'favicon', 'value' => $favicon];
						
						/* $db->beginTransaction();
						$db->delete('setting_web');
						$result = $db->insertBatch('setting_web', $data_db);
						$query = $db->completeTransaction();
						
						if ($query) {
							$file_name = THEME_PATH . 'assets/css/login-header.css';
							if (file_exists($file_name)) {
								file_put_contents($file_name, '.login-header {background-color: ' . $_POST['background_logo'] . ';}');
							}
							$data['status'] = 'ok';
							$data['message'] = 'Data berhasil disimpan';
						} else {
							$data['status'] = 'error';
							$data['message'] = 'Data gagal disimpan';
						} */
						
					} else {
						$data['msg']['status'] = 'error';
						$data['msg']['content'] = 'Error saat memperoses gambar';
					}
				}
				
			} else {
				$data['status'] = 'error';
				$data['message'] = 'Role anda tidak diperbolehkan melakukan perubahan';
			}
		}
		
		$sql = 'SELECT * FROM setting_web';
		$query = $db->query($sql)->result();
		foreach($query as $val) {
			$data[$val['param']] = $val['value'];
		}

		$data['title'] = 'Edit ' . $app_module['judul_module'];
		load_view('views/form.php', $data);
}

function validate_form() 
{
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('footer_app', 'Footer Aplikasi', 'trim|required');
	$validation->setRules('background_logo', 'Background Logo', 'trim|required');
	$validation->setRules('judul_web', 'Judul Website', 'trim|required');
	$validation->setRules('deskripsi_web', 'Deskripsi Web', 'trim|required');
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
					
	// $form_errors = [];
	if ($_FILES['logo_login']['name']) {
		
		$file_type = $_FILES['logo_login']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['logo_login'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['logo_login']['size'] > 300 * 1024) {
			$form_errors['logo_login'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['logo_login']['tmp_name']);
		if ($info[0] < 20 || $info[1] < 20) { //0 Width, 1 Height
			$form_errors['logo_login'] = 'Dimensi logo login minimal: 20px x 20px, dimensi anda ' . $info[0] . 'px x ' . $info[1] . 'px';
		}
	}
	
	if ($_FILES['logo_app']['name']) {
		
		$file_type = $_FILES['logo_app']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['logo_app'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['logo_app']['size'] > 300 * 1024) {
			$form_errors['logo_app'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['logo_app']['tmp_name']);
		if ($info[0] < 20 || $info[1] < 20) { //0 Width, 1 Height
			$form_errors['logo_app'] = 'Dimensi logo aplikasi minimal: 20px x 20px, dimensi anda ' . $info[0] . 'px x ' . $info[1] . 'px';
		}
	}
	
	if ($_FILES['favicon']['name']) {
		
		$file_type = $_FILES['favicon']['type'];
		$allowed = ['image/png'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['favicon'] = 'Tipe file harus ' . join($allowed, ', ') . ' tipe file Anda: ' . $file_type;
		}
		
		if ($_FILES['favicon']['size'] > 300 * 1024) {
			$form_errors['favicon'] = 'Ukuran file maksimal 300Kb';
		}
	}
	
	return $form_errors;
}