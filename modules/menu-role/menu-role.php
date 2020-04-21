<?php
login_required();
include ('functions.php');
$js[] = THEME_URL . 'assets/js/menu-role.js';
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-loader.css';

$sql = 'SELECT * FROM menu';
$data['menu'] = $db->query($sql)->result();

$sql = 'SELECT * FROM role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['role'][$row['id_role']] = $row;
}

$data['menu_role'] = [];
$sql = 'SELECT * FROM menu_role';
$db->query($sql);
while($row = $db->fetch()) {
	$data['menu_role'][$row['id_menu']][] = $row['id_role'];
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
				
		load_view('views/data.php', $data);
	
	// CHECKBOX - AJAX
	case 'checkbox':

		require_once('helpers/html.php');
		$prefix_id = 'role_';
		
		$sql = 'SELECT * FROM menu_role WHERE id_menu = ?';
		$db->query($sql, $_GET['id']);
		$checked = [];
		while($row = $db->fetch()) {
			$checked[] = $prefix_id . $row['id_role'];
		}
		$data['prefix_id'] = $prefix_id;
		$data['checked'] = $checked;
		echo load_view('views/form-edit.php', $data, true, true);
		break;
	
	// DELETE ROLE - AJAX
	case 'delete-role':
		if (isset($_POST['id_menu'])) 
		{
			$query = $db->delete('menu_role', ['id_menu' => $_POST['id_menu'], 'id_role' => $_POST['id_role']]);
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
		if (isset($_POST['id_menu'])) 
		{
			// Find all parent
			$menu_parent = all_parents($_POST['id_menu']);
	
			// Cek role yang tercentang
			foreach ($_POST as $key => $val) {
				$exp = explode('_', $key);
				if ($exp[0] == 'role') {
					$id_role = $exp[1];
					$insert[] = ['id_menu' => $_POST['id_menu'], 'id_role' => $exp[1]];
					$curr_id_role[$id_role] = $id_role;
				}
			}
			
			$insert_parent = [];
			if ($menu_parent) 
			{
				// Cek apakah parent telah diassign di role yang tercentang, jika belum buat insert nya
				foreach($menu_parent as $id_menu_parent) {
					foreach ($curr_id_role as $id_role) {
						$sql = 'SELECT * FROM menu_role WHERE id_menu = ? AND id_role = ?';
						$data = [$id_menu_parent, $id_role];
						$query = $db->query($sql, $data)->row();
						if (!$query) {
							$insert_parent[] = ['id_menu' => $id_menu_parent, 'id_role' => $id_role];
						}
					}
				}

				// Delete parent
				// Cari role yang tidak tercentang, kemudian hapus dari tabel
				$sql = 'SELECT * FROM role';
				$result = $db->query($sql)->result();
				foreach($result as $val) {
					if (!key_exists($val['id_role'], $curr_id_role)) {
						$role_del[$val['id_role']] = $val['id_role'];
					}
				}
			}
			

			// INSERT - DELETE
			$db->beginTransaction();
			if ($insert_parent) {
				$db->insertBatch('menu_role', $insert_parent);
			}
			
			// Hapus role yang tidak tercentang
			foreach ($role_del as $id_role) {
				$db->delete('menu_role', ['id_menu' => $_POST['id_menu'], 'id_role' => $id_role]);
			}

			// Insert role yang tercentang
			foreach ($curr_id_role as $id_role) 
			{
				$sql = 'SELECT * FROM menu_role WHERE id_menu = ? AND id_role = ?';
				$query = $db->query($sql, [$_POST['id_menu'], $id_role])->row();
				if (!$query) {
					$db->insert('menu_role', ['id_menu' => $_POST['id_menu'], 'id_role' => $id_role]);
				}
			}

			$query = $db->completeTransaction();
			
			if ($query) {
				$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan', 'data_parent' => json_encode($insert_parent)];
			} else {
				$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
			}

			echo json_encode($message);
			exit;
		}
		break;
}