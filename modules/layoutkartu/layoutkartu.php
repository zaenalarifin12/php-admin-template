<?php
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

login_required();
$js[] = BASE_URL . 'themes/modern/assets/js/set-default.js';
$site_title = 'Home Page';

switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		
		if (!empty($_POST['delete'])) 
		{
			$result = $db->delete('layout_kartu', ['id_layout_kartu' => $_POST['id']]);
			// $result = true;
			if ($result) {
				$sql = 'SELECT COUNT(*) AS jml_data FROM layout_kartu WHERE gunakan = 1';
				$jml_data = $db->query($sql)->row();
				if ($jml_data['jml_data'] == 0) {
					$sql = 'SELECT id_layout_kartu FROM layout_kartu ORDER BY id_layout_kartu DESC LIMIT 1';
					$id = $db->query($sql)->row();
					if ($id) {
						$data_db['gunakan'] = 1;
						$query = $db->update('layout_kartu', $data_db, 'id_layout_kartu = ' . $id['id_layout_kartu']);
					}
				}
				$data['msg'] = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
		}
		$sql = 'SELECT * FROM layout_kartu ORDER BY gunakan DESC';
		$data['result'] = $db->query($sql)->result();
		
		// echo '<pre>'; print_r($data['result']);
		
		if (!$data['result']) {
			$data['msg']['status'] = 'error';
			$data['msg']['content'] = 'Data tidak ditemukan';
		}
		
		load_view('views/result.php', $data);
	
	case 'add':
		$breadcrumb['Add'] = '';
		if (isset($_POST['submit'])) 
		{
			$data_db = set_datadb();
			$path = $config['kartu_path'];
			$form_errors = validate_form();
			
			if (!is_dir($path)) {
				if (!mkdir($path, 0777, true)) {
					$form_errors['path'] = 'Unable to create a directory: ' . $path;
				}
			} 
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {

				$new_name_depan = upload_image($path, $_FILES['background_depan']);
				$new_name_belakang = upload_image($path, $_FILES['background_belakang']);
				
				if ($new_name_depan && $new_name_belakang) 
				{
					$data_db['background_depan'] = $new_name_depan;
					$data_db['background_belakang'] = $new_name_belakang;
					$sql = 'SELECT COUNT(*) AS jml_data FROM layout_kartu';
					$jml_data = $db->query($sql)->row();
					if ($jml_data['jml_data'] == 0) {
						$data_db['gunakan'] = 1;
					}
					$query = $db->insert('layout_kartu', $data_db);
					if ($query) {
						$newid = $db->lastInsertId();
						$sql = 'SELECT * FROM layout_kartu WHERE id_layout_kartu = ?';
						$data = $db->query($sql, $newid)->row();
					} else {
						$data['msg']['status'] = 'error';
						$data['msg']['content'] = 'Data gagal disimpan';
					}
					
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Error saat memperoses gambar';
				}
			}
		}
		
		$data['title'] = 'Tambah ' . $app_module['judul_module'];
		// echo '<pre>'; print_r($data);
		load_view('views/form.php', $data);
	case 'edit': 
		
		$breadcrumb['Edit'] = '';
					
		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			// Check Error
			$form_errors = validate_form();
			
			$sql = 'SELECT background_depan, background_belakang FROM layout_kartu WHERE id_layout_kartu = ?';
			$query_img = $db->query($sql, $_POST['id'])->row();
			$img_db['background_depan'] = $query_img['background_depan'];
			$img_db['background_belakang'] = $query_img['background_belakang'];
			
			if (!$_FILES['background_depan']['name']) {
				if ($img_db['background_depan'] == '') {
					$form_errors['background_depan'] = 'Background depan belum dipilih';
				}
			} 
			
			if (!$_FILES['background_belakang']['name']) {
				if ($img_db['background_belakang'] == '') {
					$form_errors['background_belakang'] = 'Background belakang belum dipilih';
				}
			}
	
			// $merge_valid = array_merge($form_errors, $valid);
			
			// echo '<pre>'; print_r($form_errors); die;
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
		
				$data_db = set_datadb();
				$path = $config['kartu_path'];
				$query = false;
				
				// Depan
				$new_name_depan = $img_db['background_depan'];
				if ($_FILES['background_depan']['name']) 
				{
					//old file
					if ($img_db['background_depan']) {
						if (file_exists($path . $img_db['background_depan'])) {
							$unlink = unlink($path . $img_db['background_depan']);
							if (!$unlink) {
								$data['msg']['status'] = 'error';
								$data['msg']['content'] = 'Gagal menghapus gambar lama';
							}
						}
					}
					
					$new_name_depan = upload_image($path, $_FILES['background_depan']);
				}
				
				// Belakang
				$new_name_belakang = $img_db['background_belakang'];
				if ($_FILES['background_belakang']['name']) 
				{
					//old file
					if ($img_db['background_belakang']) {
						if (file_exists($path . $img_db['background_belakang'])) {
							$unlink = unlink($path . $img_db['background_belakang']);
							if (!$unlink) {
								$data['msg']['status'] = 'error';
								$data['msg']['content'] = 'Gagal menghapus gambar lama';
							}
						}
					}
					
					$new_name_belakang = upload_image($path, $_FILES['background_belakang']);
				}

				if ($new_name_depan && $new_name_belakang) {
					$data_db['background_depan'] = $new_name_depan;
					$data_db['background_belakang'] = $new_name_belakang;
					$query = $db->update('layout_kartu', $data_db, 'id_layout_kartu = ' . $_POST['id']);
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Error saat memperoses gambar';
				}
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['content'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Data gagal disimpan';
				}
			}
		}
		$sql = 'SELECT * FROM layout_kartu WHERE id_layout_kartu = ?';
		$result = $db->query($sql, trim($_GET['id']))->result();
		$data	= $result[0];
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		// echo '<pre>'; print_r($data);die;
		load_view('views/form.php', $data);
		
	case 'set-default':
		if (isset($_POST['submit'])) 
		{
			$data_db['gunakan'] = 0;
			$query = $db->update('layout_kartu', $data_db);
			$query = $db->update('layout_kartu', ['gunakan' => 1], 'id_layout_kartu = ' . $_POST['id']);
			if ($query) {
				$data['msg']['status'] = 'ok';
				$data['msg']['content'] = 'Data berhasil diupdate';
				
			} else {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = 'Data gagal diupdate';
			}
			// show_alert($data);
			echo json_encode($data); 
			die;	
		}
}

function set_datadb() {
	$data_db['nama_layout'] = $_POST['nama_layout'];
	$data_db['panjang'] = $_POST['panjang'];
	$data_db['lebar'] = $_POST['lebar'];
	$data_db['berlaku'] = $_POST['berlaku'];
	
	return $data_db;
}
function validate_form() 
{
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('nama_layout', 'Nama Layout', 'required');
	$validation->setRules('panjang', 'Panjang', 'trim|required');
	$validation->setRules('lebar', 'Lebar', 'trim|required');
	$validation->setRules('berlaku', 'Berlaku', 'trim|required');
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
					
	// $form_errors = [];
	if ($_FILES['background_depan']['name']) {
		
		$file_type = $_FILES['background_depan']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['background_depan'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['background_depan']['size'] > 300 * 1024) {
			$form_errors['background_depan'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['background_depan']['tmp_name']);
		if ($info[0] < 100 || $info[1] < 100) { //0 Width, 1 Height
			$form_errors['background_depan'] = 'Dimensi file minimal: 100px x 100px';
		}
	}
	
	if ($_FILES['background_belakang']['name']) {
		
		$file_type = $_FILES['background_belakang']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['background_belakang'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['background_belakang']['size'] > 300 * 1024) {
			$form_errors['background_belakang'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['background_belakang']['tmp_name']);
		if ($info[0] < 100 || $info[1] < 100) { //0 Width, 1 Height
			$form_errors['background_belakang'] = 'Dimensi file minimal: 100px x 100px';
		}
	}
	
	return $form_errors;
}