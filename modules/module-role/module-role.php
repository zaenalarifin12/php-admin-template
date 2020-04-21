<?php
login_required();
include ('functions.php');
$js[] = THEME_URL . 'assets/js/module-role.js';
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-loader.css';

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
		
switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
	
		// Delete
		if (!empty($_POST['delete'])) {
			$result = $db->delete('role', ['id_role' => $_POST['id']]);
			// $result = false;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data module-role berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data module-role gagal dihapus'];
			}
		}
		
		$sql = 'SELECT * FROM module
				LEFT JOIN module_status USING(id_module_status)';
		$data['result'] = $db->query($sql)->result();
		
		load_view('views/data.php', $data);
		
	// CHECKBOX - AJAX
	case 'checkbox':

		require_once('helpers/html.php');
		$prefix_id = 'role_';
		
		$sql = 'SELECT * FROM module_role WHERE id_module = ?';
		$db->query($sql, $_GET['id']);
		$checked = [];
		while($row = $db->fetch()) {
			$checked[] = $prefix_id . $row['id_role'];
		}

		$checkbox[] = ['id' => 'check-all', 'name' => 'check_all', 'label' =>'Check All / Uncheck All'];
		$check_all_checked = $checked ? ['check_all'] : [];
		checkbox($checkbox, $check_all_checked);

		echo '<hr class="mt-1 mb-2"/>';
		echo '<form method="post" id="check-all-wrapper" action="">';
		$checkbox = [];
		foreach ($data['role'] as $val) {
			$checkbox[] = ['id' => $val['id_role'], 'name' => $prefix_id . $val['id_role'], 'label' => $val['judul_role']];
		}
		
		checkbox($checkbox, $checked);
		echo '</form>';
		break;
	
	// DELETE ROLE - AJAX
	case 'delete-role':
		if (isset($_POST['pair_id'])) 
		{
			$query = $db->delete('module_role', ['id_module' => $_POST['pair_id'], 'id_role' => $_POST['id_role']]);
			if ($query) {
				$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
			echo json_encode($message);
			exit;
		}
		
	// EDIT
	case 'detail':
		$breadcrumb['Detail'] = '';
		
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		$sql = 'SELECT * FROM module WHERE id_module = ' . $_GET['id'];
		$data['module'] = $db->query($sql)->row();
		
		$sql = 'SELECT * FROM role';
		$data['role'] = $db->query($sql)->result();
		
		$sql = 'SELECT * FROM role_detail';
		$data['role_detail'] = $db->query($sql)->result();
		
		$sql = 'SELECT * FROM module_role WHERE id_module = ' . $_GET['id'];
		$data['module_role'] = $db->query($sql)->result();
		
		load_view('views/detail.php', $data);
	
	// EDIT
	case 'edit':
		$breadcrumb['Edit'] = '';
		
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		$sql = 'SELECT * FROM module WHERE id_module = ' . $_GET['id'];
		$data['module'] = $db->query($sql)->row();
		
		$sql = 'SELECT * FROM role';
		$data['role'] = $db->query($sql)->result();
		
		$sql = 'SELECT * FROM role_detail';
		$data['role_detail'] = $db->query($sql)->result();
		
		$sql = 'SELECT * FROM module_role WHERE id_module = ' . $_GET['id'];
		$data['module_role'] = $db->query($sql)->result();
		// Submit data
		if (isset($_POST['submit'])) 
		{
			require_once('libraries/form_validation.php');
			$error = checkForm();
			
			if ($error) {
				$message['status'] = 'error';
				$message['content'] = $error;
			} else {
				
				foreach ($_POST as $key => $val) {
					$exp = explode('_', $key);
					if ($exp[0] == 'role') {
						$id_role = $exp[1];
						$insert[] = ['id_module' => $_POST['id']
										, 'id_role' => $id_role
										, 'read_data' => $_POST['akses_read_data_' . $id_role]
										, 'create_data' => $_POST['akses_create_data_' . $id_role]
										, 'update_data' => $_POST['akses_update_data_' . $id_role]
										, 'delete_data' => $_POST['akses_delete_data_' . $id_role]
									];
					}
				}
				
				// INSERT - UPDATE
				$db->beginTransaction();
				$db->delete('module_role', ['id_module' => $_POST['id']]);
				$db->insertBatch('module_role', $insert);
				$query = $db->completeTransaction();
				
				if ($query) {
					$message = ['status' => 'ok', 'content' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'content' => 'Data gagal disimpan'];
				}
			}
			$data['msg'] = $message;
		}
		
		load_view('views/form-add.php', $data);
		break;
}