<?php
login_required();
include ('functions.php');
$js[] = THEME_URL . 'assets/js/user-role.js';
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-loader.css';

$sql = 'SELECT * FROM role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['role'][$row['id_role']] = $row;
}

$data['user_role'] = [];
$sql = 'SELECT * FROM user_role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['user_role'][$row['id_user']][] = $row['id_role'];
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
				$data['msg'] = ['status' => 'ok', 'message' => 'Data user-role berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data user-role gagal dihapus'];
			}
		}
		
		// Get user
		$sql = 'SELECT * FROM user ';
		$data['users'] = $db->query($sql)->result();
		
		load_view('views/data.php', $data);
	
	// CHECKBOX - AJAX
	case 'checkbox':

		require_once('helpers/html.php');
		$prefix_id = 'role_';
		
		$sql = 'SELECT * FROM user_role WHERE id_user = ?';
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
			$query = $db->delete('user_role', ['id_user' => $_POST['pair_id'], 'id_role' => $_POST['id_role']]);
			if ($query) {
				$message = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$message = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
			echo json_encode($message);
			exit;
		}
	
	// EDIT - AJAX
	case 'edit':
		
		// Submit data
		if (isset($_POST['pair_id'])) 
		{
			require_once('libraries/form_validation.php');
			$error = checkForm();
			
			if ($error) {
				$message['status'] = 'error';
				$message['message'] = $error;
			} else {
				
				foreach ($_POST as $key => $val) {
					$exp = explode('_', $key);
					if ($exp[0] == 'role') {
						$insert[] = ['id_user' => $_POST['pair_id'], 'id_role' => $exp[1]];
					}
				}
				
				// INSERT - UPDATE
				$db->beginTransaction();
				$db->delete('user_role', ['id_user' => $_POST['pair_id']]);
				$db->insertBatch('user_role', $insert);
				$query = $db->completeTransaction();
				
				if ($query) {
					$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
				} else {
					$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
				}
			}
			
			echo json_encode($message);
			exit;
		}
		break;
}