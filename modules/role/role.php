<?php
login_required();
$styles[] = BASE_URL . 'assets/vendors/bulma-switch/bulma-switch.min.css?r=' . time();
$js[] = THEME_URL . 'assets/js/admin-role.js';
$site_title = 'Home Page';


switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		
		if (!empty($_POST['delete'])) {
			$result = $db->delete('role', ['id_role' => $_POST['id']]);
			// $result = false;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data role berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data role gagal dihapus'];
			}
		}
		
		// Module / Menu All
		if (!empty($_POST['change_status'])) 
		{
			$update_status = $db->update('role', 
						[$_POST['name'] => $_POST['status_id']], 
						['id_role' => $_POST['id_role']]
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
		
		$sql = 'SELECT * FROM module';
		$result = $db->query($sql)->result();
		$data['module'] = $result;
		
		$sql = 'SELECT * FROM module_status';
		$result = $db->query($sql)->result();
		$data['module_status'] = $result;
		
		$sql = 'SELECT * FROM module_role LEFT JOIN module USING(id_module)';
		$result = $db->query($sql)->result();
		$data['module_role'] = $result;

		$sql = 'SELECT * FROM role';
		$data['result'] = $db->query($sql)->result();
		
		load_view('views/data.php', $data);
	
	case 'add':
	
		global $db;	
		$data['title'] = 'Tambah Role';
		$breadcrumb['Add'] = '';
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['nama_role'])) 
		{
			require_once('libraries/form_validation.php');
			$validation = new FormValidation();
			$validation->setRules('nama_role', 'Nama Role', 'required|unique[role]');
			$validation->setRules('judul_role', 'Judul Role', 'required');
			$valid = $validation->validate();
			
			if (!$valid) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $validation->getMessage();
			} else {
				$data_db['nama_role'] = $_POST['nama_role'];
				$data_db['judul_role'] = $_POST['judul_role'];
				$data_db['keterangan'] = $_POST['keterangan'];
				
				$query = $db->insert('role', $data_db);
				$last_id = $db->lastInsertId();
				$data['msg']['id_role'] = $last_id;
				$message = 'Role berhasil ditambahkan';
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = $message;
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}	
			}
		}
		
		load_view('views/form.php', $data);
		break;
		
	// EDIT
	case 'edit':
	
		global $db;	
		$data['title'] = 'Edit Role';
		$breadcrumb['Edit'] = '';
		
		$sql = 'SELECT * FROM role WHERE id_role = ?';
		$result = $db->query($sql, trim($_GET['id']))->row();
		$data['role'] = $result;
					
		$data['title'] = 'Edit Data Role';
		
		$sql = 'SELECT * FROM module_role LEFT JOIN module USING(id_module)';
		$result = $db->query($sql)->result();
		$data['module_role'] = $result;
		
		$sql = 'SELECT * FROM module_status';
		$result = $db->query($sql)->result();
		$data['module_status'] = $result;
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['nama_role'])) 
		{
			require_once('libraries/form_validation.php');
			$validation = new FormValidation();
			
			//Cek duplikasi
			if ($_POST['id']) {
				$sql = 'SELECT * FROM role WHERE id_role = ?';
				$result = $db->query($sql, trim($_POST['id']))->row();
				if ($result['nama_role'] == $_POST['nama_role']) {
					$validation->setRules('nama_role', 'Nama Role', 'required');
				} else {
					$validation->setRules('nama_role', 'Nama Role', 'required|unique[role]');
				}
			}
			$validation->setRules('judul_role', 'Judul Role', 'required');
			$valid = $validation->validate();
			
			if (!$valid) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $validation->getMessage();
			} else {
				$data_db['nama_role'] = $_POST['nama_role'];
				$data_db['judul_role'] = $_POST['judul_role'];
				$data_db['keterangan'] = $_POST['keterangan'];
				
				$query = $db->update('role', $data_db, 'id_role = ' . $_POST['id']);
				$message = 'Role berhasil diupdate';

				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = $message;
					$data['title'] = 'Edit Data Role';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}	
			}
		}
		
		load_view('views/form.php', $data);
		break;
}