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
			require_once('libraries/form_validation.php');
			$error = checkForm();
			
			if ($error) {
				$message['status'] = 'error';
				$message['message'] = $error;
			} else {
				
				// Find all parent
				// $all_parents = all_parents($_POST['pair_id']);
				// print_r($_POST);
				
				$menu_parent = all_parents($_POST['id_menu']);
				// print_r($menu_parent); die;
				
				$id_menu = [];
				foreach ($_POST as $key => $val) {
					$exp = explode('_', $key);
					if ($exp[0] == 'role') {
						$id_role = $exp[1];
						$insert[] = ['id_menu' => $_POST['id_menu'], 'id_role' => $exp[1]];
						$curr_id_role[$id_role] = $id_role;
					}
				}
				
				if ($menu_parent) 
				{
					$sql = 'SELECT * FROM role';
					$result = $db->query($sql)->result();
					foreach($result as $val) {
						$role[$val['id_role']] = $val['judul_role'];
					}
					
					// Cek apakah parent ada di module_role
					foreach ($menu_parent as $val) 
					{
						$sql = 'SELECT * FROM menu_role WHERE id_menu = ?';
						$query = $db->query($sql, $val)->result();
						foreach($query as $val_query) {
							/*
							Buat array berdasarkan id_role
							Array
							(
								[1] => Array
									(
										[8] => 8
									)

								[2] => Array
									(
										[8] => 8
									)

							)
	
							*/
							$parent_del[$val_query['id_role']][$val] = $val;
							
							/* Buat array berdasarkan id_menu
								Array
								(
									[8] => Array
										(
											[1] => 1
											[2] => 2
										)

								)*/
							$role_parent[$val][$val_query['id_role']] = $val_query['id_role'];
						}
					}
					
					// Insert Parent
					/*
						Array
						(
							[1] => 1
							[2] => 2
						)
						*/
					foreach($role_parent as &$id_role_parent) {
						foreach($curr_id_role as $id_role) {
							$id_role_parent[$id_role] = $id_role;
						}
					}
					
					
					/* 
					Buat format insert
						Array
						(
							[0] => Array
								(
									[id_menu] => 8
									[id_role] => 1
								)

							[1] => Array
								(
									[id_menu] => 8
									[id_role] => 2
								)

						)
						*/
					foreach ($role_parent as $id_menu => $arr_id_role) {
						foreach ($arr_id_role as $id_role) {
							$insert_parent[] = ['id_menu' => $id_menu, 'id_role' => $id_role];
						}
					}
					
					
					
					echo '<pre>'; print_r($insert_parent); die;
					
					// Delete parent
					foreach ($role as $id_role => $judul_role) {
						if (!key_exists($id_role, $curr_id_role)) {
							$role_del[$id_role] = $id_role;
							// echo $id_role; die;
							$sql = 'SELECT * FROM menu_role WHERE id_role = ?';
							$query = $db->query($sql, $id_role)->result();
							foreach($query as $val) {
								if (!key_exists($val['id_menu'], $parent_del) && $val['id_menu'] != $_POST['id_menu']) {
									$menu_assigned[$id_role][$val['id_menu']] = $val['id_menu'];
								}
							}
						}
					}
					
					foreach ($menu_assigned as $id_role => $arr_menu) {
						$parent_assigned[$id_role] = [];
						foreach($arr_menu as $id_menu) {
							$parent_assigned[$id_role] += all_parents($id_menu);
						}
					}
				}
				

				// INSERT - UPDATE
				$db->beginTransaction();
				$db->delete('menu_role', ['id_menu' => $_POST['id_menu']]);
				
				foreach ($role_parent as $id_menu => $arr) {
					$db->delete('menu_role', ['id_menu' => $id_menu]);
				}
				$db->insertBatch('menu_role', $insert_parent);
				
				foreach ($role_del as $id_role => $arr_menu) 
				{
					$assign = [];
					if (key_exists($id_role, $parent_assigned)) {
						$assign = $parent_assigned[$id_role];		
					}
					if (key_exists($id_role, $parent_del)) {
						foreach($parent_del[$id_role] as $id_menu) {
							if (!in_array($id_menu, $assign)) {
								$db->delete('menu_role', ['id_menu' => $id_menu, 'id_role' => $id_menu]);
							}
						}							
					}
				}
				
				$db->insertBatch('menu_role', $insert);
				$query = $db->completeTransaction();
				
				if ($query) {
					$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan', 'data' => json_encode($id_menu)];
				} else {
					$message = ['status' => 'error', 'message' => 'Data gagal disimpan'];
				}
			}
			
			echo json_encode($message);
			exit;
		}
		break;
}