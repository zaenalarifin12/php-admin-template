<?php
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

login_required();
$js[] = BASE_URL . 'themes/modern/assets/js/setting.js';
$styles[] = BASE_URL . 'themes/modern/assets/css/setting.css';
$site_title = 'Home Page';
$params = ['color_scheme' => 'Color Scheme'
			, 'sidebar_color' => 'Sidebar Color'
			, 'logo_background_color' => 'Background Logo'
			, 'font_family' => 'Font Family'
			, 'font_size' => 'Font Size'
		];

switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':

		if (!empty($_POST['submit'])) 
		{
			$query = false;
			$role_error = false;
			foreach ($params as $param => $title) {
				$data_db[] = ['param' => $param, 'value' => $_POST[$param]];
				$arr[$param] = $_POST[$param];
			}
			
			if ($module_role[$_SESSION['user']['id_role']]['update_data'] == 'all')
			{
				$db->beginTransaction();
				$db->delete('setting_app_tampilan');
				$result = $db->insertBatch('setting_app_tampilan', $data_db);
				$query = $db->completeTransaction();
				
				if ($query) {
					$file_name = THEME_PATH . 'assets/css/fonts/font-size-' . $_POST['font_size'] . '.css';
					if (!file_exists($file_name)) {
						file_put_contents($file_name, 'html, body { font-size: ' . $_POST['font_size'] . 'px }');
					}						
				}
				// $query = true;
				
			} else if ($module_role[$_SESSION['user']['id_role']]['update_data'] == 'own') 
			{
				$db->beginTransaction();
				$db->delete('setting_app_user', $_SESSION['user']['id_user']);
				$result = $db->insert('setting_app_user', ['id_user' => $_SESSION['user']['id_user']
																, 'param' => json_encode($arr)
															]
								);
				$query = $db->completeTransaction();
				
			} else {
				$data['status'] = 'error';
				$data['message'] = 'Role anda tidak diperbolehkan melakukan perubahan';
				$role_error = true;
			}
			
			if (!$role_error) {
				if ($query) {
					$data['status'] = 'ok';
					$data['message'] = 'Data berhasil disimpan';
				} else {
					$data['status'] = 'error';
					$data['message'] = 'Data gagal disimpan';
				}
			}
			
			if (!empty($_POST['ajax'])) {
				echo json_encode($data); die;
			}
		}
		
		$user_setting = $db->query('SELECT * FROM setting_app_user WHERE id_user = ?', $_SESSION['user']['id_user'])
					->row();
					
		if ($user_setting) {
			$data = json_decode($user_setting['param'], true);
		} else {
			$sql = 'SELECT * FROM setting_app_tampilan';
			$query = $db->query($sql)->result();
			foreach($query as $val) {
				$data[$val['param']] = $val['value'];
			}
		}
		
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		load_view('views/form.php', $data);
}

function validate_form() 
{
	global $params;
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	
	foreach($params as $param => $title) {
		$validation->setRules($param, $title, 'required');
	}
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
	
	return $form_errors;
}