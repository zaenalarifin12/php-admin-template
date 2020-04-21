<?php
$styles[] = BASE_URL . 'assets/vendors/bulma-switch/bulma-switch.min.css?r=' . time();
$js[] = THEME_URL . 'assets/js/admin-module.js';

$sql = 'SELECT * FROM module';
$data['module'] = $db->query($sql)->result();

$sql = 'SELECT * FROM role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['role'][$row['id_role']] = $row;
}

$sql = 'SELECT * FROM module_role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['module_role'][$row['id_module']][] = $row['id_role'];
}


$fields = ['nama_module', 'judul_module', 'deskripsi', 'id_module_status'];
switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
	
		// Delete
		if (!empty($_POST['delete'])) {
			$result = $db->delete('module', ['id_module' => $_POST['id']]);
			// $result = false;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data role berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data role gagal dihapus'];
			}
		}
		
		// Module Aktif/Nonaktif/Login
		if (!empty($_POST['change_module_attr'])) 
		{
			$field = $_POST['switch_type'] == 'aktif' ? 'id_module_status' : 'login';
	
			$update_status = $db->update('module', 
						[$field => $_POST['id_result']], 
						['id_module' => $_POST['id_module']]
					);
					
			if (!empty($_POST['ajax'])) {
				if ($update_status) {
					echo 'ok';
				} else {
					echo 'error';
				}
				die();
			}
		}
		
		$sql = 'SELECT * FROM module
				LEFT JOIN module_status USING(id_module_status)';
		$data['result'] = $db->query($sql)->result();
		
		load_view('views/data.php', $data);

	// EDIT
	case 'add':
		$data['title'] = 'Tambah Module';
		$breadcrumb['Add'] = '';
		
		$sql = 'SELECT * FROM module_status';
		$data['module_status'] = $db->query($sql)->result();
		
		if (isset($_POST['submit'])) 
		{
			
			$form_errors = validate_form();
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $form_errors;
			} else {
				$data_db = prepare_datadb($fields);
				$query = $db->insert('module', $data_db);
				if ($query) {
					$last_id = $db->lastInsertId();
					$data['msg']['id_module'] = $last_id;
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}
			}
		}
		load_view('views/form.php', $data);
		
		
	case 'edit':
	
		$sql = 'SELECT * FROM module WHERE id_module = ?';
		$result = $db->query($sql, trim($_GET['id']))->row();
		$data = $result;		
		$data['title'] = 'Edit Data Module';

		// List module status
		$sql = 'SELECT * FROM module_status';
		$data['module_status'] = $db->query($sql)->result();
		
		// Submit data
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			require_once('libraries/form_validation.php');
			$validation = new FormValidation();
			$unique = false;
			if ($_POST['nama_module'] != $_POST['nama_module_old']) {
				$unique = true;
			}
			
			$form_errors = validate_form(true);
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $form_errors;
			} else {
				$data_db = prepare_datadb($fields);
				$query = $db->update('module', $data_db, 'id_module = ' . $_POST['id']);
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}	
			}
		}

		$breadcrumb['Edit'] = '';
		load_view('views/form.php', $data);
		break;
}

function validate_form($check_unique = false) 
{
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$unique = '';
	if ($check_unique) {
		$unique = '|unique[module]';
	}
	$validation->setRules('nama_module', 'Nama Module', 'trim|required' . $unique);
	$validation->setRules('judul_module', 'Judul Module', 'trim|required');
	$validation->setRules('deskripsi', 'Judul Module', 'trim|required');
	$validation->setRules('id_module_status', 'Judul Module', 'trim|required');
	$validation->validate();
	return $validation->getMessage();
}