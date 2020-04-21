<?php
login_required();

// Role 
$sql = 'SELECT * FROM role';
$role = $db->query($sql)->result();
$data['role'] = $role;
		
switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		cek_hakakses('read_data');

		if (!empty($_POST['delete'])) 
		{
			cek_hakakses('delete_data');
			$result = $db->delete('user', ['user_id' => $_POST['id']]);
			// $result = true;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data user berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data user gagal dihapus'];
			}
		}
		$data['title'] = 'Data User';
		
		// Get user
		$where = '';
		// print_r($list_action['read_data']); die;
		if ($list_action['read_data'] == 'own') {
			$where .= ' WHERE id_user = ' . $_SESSION['user']['id_user'];
		}
		
		$sql = 'SELECT * FROM user LEFT JOIN role USING(id_role)' . $where;
		
		$data['users'] = $db->query($sql)->result();
		
		if (!$data['users']) {
			$data['msg'] = ['status' => 'error', 'message' => 'Data user tidak ditemukan'];
		}
		
		$data['form'] = load_view('views/form-cari.php', $data, true);
		load_view('views/result.php', $data);
			
				
		/* if (!empty($_GET['id'])) 
		{
			$sql = 'SELECT * FROM user WHERE user_jenis_id = ?';
			$result = $db->query($sql, $_GET['gedung_id'])->result();
			if ($result) {
				
			}
			$data['msg'] = ['status' => 'error', 'message' => 'Data ruangan tidak ditemukan'];
			load_view('views/form-cari.php', $data);
		} else {
		
			load_view('views/form-cari.php', $data);
		} */
	
	case 'add':
		cek_hakakses('create_data');
		
		$breadcrumb['Add'] = '';
	
		$data['title'] = 'Tambah ' . $app_module['judul_module'];
		$data['msg'] = [];
		$error = false;
		if (isset($_POST['submit'])) 
		{
			require_once('libraries/form_validation.php');
			$validation = new FormValidation();
			$validation->setRules('username', 'Username', 'trim|required|unique[user]');
			$validation->setRules('nama', 'Nama', 'trim|required');
			$validation->setRules('email', 'Email', 'trim|required|valid_email');
			$validation->setRules('password', 'Password', 'trim|required|min_length[3]');
			if ($list_action['update_data'] == 'all') {
				$validation->setRules('id_role', 'Role', 'trim|required');
			}
			$valid = $validation->validate();
			
			if (!$valid) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $validation->getMessage();
				$error = true;
			} 
			
			if ($_POST['password'] !== $_POST['ulangi_password']) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'][] = 'Password baru dengan ulangi password baru tidak sama'; 
				$error = true;
			}
			
			if (!$error) {
				
				$fields = ['username', 'nama', 'email'];
				if ($list_action['update_data'] == 'all') { 
					$fields[] = 'id_role';
				}
				foreach ($fields as $field) {
					$data_db[$field] = $_POST[$field];
				}
			
				$data_db['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);				
				$query = $db->insert('user', $data_db);

				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}
				
				$data['title'] = 'Edit Data Ruangan';
				
			}
		}
		load_view('views/form-add.php', $data);
		
	case 'edit': 
			
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		$breadcrumb['Edit'] = '';
			
		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			$form_errors = validate_form();
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $form_errors;
			} else {
				
				// Assign fields table
				$fields = ['nama', 'email'];
				if ($list_action['update_data'] == 'all') { 
					$fields[] = 'id_role';
				}
				
				foreach ($fields as $field) {
					$data_db[$field] = $_POST[$field];
				}
				
				$sql = 'SELECT avatar FROM user WHERE id_user = ?';
				$result = $db->query($sql, trim($_GET['id']))->row();
				$img_db = $result;
		
				$path = $config['user_images_path'];
				$new_name = $img_db['avatar'];
				if ($_FILES['avatar']['name']) 
				{
					//old file
					if ($img_db['avatar']) {
						if (file_exists($path . $img_db['avatar'])) {
							$unlink = unlink($path . $img_db['avatar']);
							if (!$unlink) {
								$data['msg']['status'] = 'error';
								$data['msg']['message'] = 'Gagal menghapus gambar lama';
							}
						}
					}
					
					$new_name = upload_image($path, $_FILES['avatar'], 300, 300);
				}
				
				if ($new_name) {
					$data_db['avatar'] = $new_name;
					
					$query = $db->update('user', $data_db, 'id_user = ' . $_POST['id']);
					if ($query) {
						$data['msg']['status'] = 'ok';
						$data['msg']['message'] = 'Data berhasil disimpan';
					} else {
						$data['msg']['status'] = 'error';
						$data['msg']['message'] = 'Data gagal disimpan';
					}
				} else {
					
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Error saat memperoses gambar';
				}
			}
		}
		$sql = 'SELECT * FROM user WHERE id_user = ?';
		$result = $db->query($sql, trim($_GET['id']))->row();
		$data = array_merge($data, $result);
		
		load_view('views/form-edit.php', $data);
		
	case 'edit-password': 
			
		$sql = 'SELECT * FROM user WHERE id_user = ?';
		$result = $db->query($sql, trim($_GET['id']))->row();
		$data = $result;
		$data['title'] = 'Edit Password';
		$breadcrumb['Edit Password'] = '';
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			require_once('libraries/form_validation.php');
			$validation = new FormValidation();
			$validation->setRules('password_baru', 'Password Baru', 'trim|required');
			$validation->setRules('ulangi_password_baru', 'Ulangi Password Baru', 'trim|required');
			
			$valid = $validation->validate();
			
			$error = false;
			if (!$valid) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = $validation->getMessage();
				$error = true;
			} 
			
			if ($_POST['password_baru'] !== $_POST['ulangi_password_baru']) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'][] = 'Password baru dengan ulangi password baru tidak sama'; 
				$error = true;
			}
			
			if (!$error) {
				//check duplikasi username
				$data_db['password'] = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);

				// print_r($data_db); die;
				$query = $db->update('user', $data_db, 'id_user = ' . $_POST['id']);
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = 'Data berhasil diupdate';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
				}
				
				$data['title'] = 'Edit Password';
			}
		}
		load_view('views/form-edit-password.php', $data);
}

function validate_form() {
	
	global $list_action;
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('nama', 'Nama', 'trim|required');
	$validation->setRules('email', 'Email', 'trim|required|valid_email');
	if ($list_action['update_data'] == 'all') {
		$validation->setRules('id_role', 'Role', 'trim|required');
	}
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
			
	if ($_FILES['avatar']['name']) {
		
		$file_type = $_FILES['avatar']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['avatar'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['avatar']['size'] > 300 * 1024) {
			$form_errors['avatar'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['avatar']['tmp_name']);
		if ($info[0] < 100 || $info[1] < 100) { //0 Width, 1 Height
			$form_errors['avatar'] = 'Dimensi file minimal: 100px x 100px';
		}
	}
	
	return $form_errors;
}