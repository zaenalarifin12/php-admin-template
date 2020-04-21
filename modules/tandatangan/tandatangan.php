<?php
login_required();
$js[] = BASE_URL . 'themes/modern/assets/js/set-default.js';
$js[] = BASE_URL . 'assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js';
$styles[] = BASE_URL . 'assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css';

$site_title = 'Home Page';

switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		
		if (!empty($_POST['delete'])) 
		{
			$result = $db->delete('tandatangan', ['id_tandatangan' => $_POST['id']]);
			// $result = true;
			if ($result) {
				$sql = 'SELECT COUNT(*) AS jml_data FROM tandatangan WHERE gunakan = 1';
				$jml_data = $db->query($sql)->row();
				if ($jml_data['jml_data'] == 0) {
					$sql = 'SELECT id_tandatangan FROM tandatangan ORDER BY id_tandatangan DESC LIMIT 1';
					$id = $db->query($sql)->row();
					if ($id) {
						$data_db['gunakan'] = 1;
						$query = $db->update('tandatangan', $data_db, 'id_tandatangan = ' . $id['id_tandatangan']);
					}
				}
				$data['msg'] = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
		}
		$sql = 'SELECT * FROM tandatangan ORDER BY gunakan DESC';
		$data['result'] = $db->query($sql)->result();
		
		if (!$data['result']) {
			$data['msg']['status'] = 'error';
			$data['msg']['content'] = 'Data tidak ditemukan';
		}
		
		load_view('views/result.php', $data);
		
	case 'add':
	
		$breadcrumb['Add'] = '';
		$data['title'] = 'Tambah ' . $app_module['judul_module'];
		$data['msg'] = [];
		
		if (isset($_POST['submit'])) 
		{
			$path = $config['kartu_path'];
			$form_errors = validate_form();
			if (!$_FILES['file_tandatangan']['name']) {
				$form_errors['file_tandatangan'] = 'File tanda tangan belum dipilih';
			}
			
			if (!is_dir($path)) {
				if (!mkdir($path, 0777, true)) {
					$data['msg']['status'] = 'error';
					$form_errors['file'] = 'Unable to create a directory: ' . $path;
				}
			}
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
				$data_db = set_data();
				$new_name_ttd = upload_file($path, $_FILES['file_tandatangan']);
				$new_name_cap = upload_file($path, $_FILES['file_cap_tandatangan']);
				
				if ($new_name_ttd && $new_name_cap) {
					
					$data_db['file_tandatangan'] = $new_name_ttd;
					$data_db['file_cap_tandatangan'] = $new_name_cap;
					$sql = 'SELECT COUNT(*) AS jml_data FROM tandatangan';
					$jml_data = $db->query($sql)->row();
					if ($jml_data['jml_data'] == 0) {
						$data_db['gunakan'] = 1;
					}
					$query = $db->insert('tandatangan', $data_db);
					if ($query) {
						$data['msg']['status'] = 'ok';
						$data['msg']['content'] = 'Data berhasil disimpan';
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
		
		load_view('views/form.php', $data);
		
	case 'edit': 
		
		$breadcrumb['Edit'] = '';
		$sql = 'SELECT * FROM tandatangan WHERE id_tandatangan = ?';
		$result = $db->query($sql, $_GET['id'])->result();
		$data	= $result[0];
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			$form_errors = validate_form();
			
			$sql = 'SELECT * FROM tandatangan WHERE id_tandatangan = ?';
			$img_db = $db->query($sql, $_POST['id'])->row();
			// print_r($img_db);
			if (!$_FILES['file_tandatangan']['name'] && $img_db['file_tandatangan'] == '') {
				$form_errors['file_tandatangan'] = 'File tanda tangan belum dipilih';
			}
					
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
				
				$data_db = set_data();
				$path = $config['kartu_path'];

				$new_name_ttd = $img_db['file_tandatangan'];
				if ($_FILES['file_tandatangan']['name']) 
				{
					//old file
					if ($img_db['file_tandatangan']) {
						if (file_exists($path . $img_db['file_tandatangan'])) {
							$unlink = unlink($path . $img_db['file_tandatangan']);
							if (!$unlink) {
								$data['msg']['status'] = 'error';
								$data['msg']['content'] = 'Gagal menghapus gambar lama';
							}
						}
					}
					
					$new_name_ttd = upload_file($path, $_FILES['file_tandatangan']);
				}
				
				// CAP
				$new_name_cap = @$img_db['file_cap_tandatangan'];
				if ($_FILES['file_cap_tandatangan']['name']) 
				{
					//old file
					if (@$img_db['file_cap_tandatangan']) {
						if (file_exists($path . $img_db['file_cap_tandatangan'])) {
							$unlink = unlink($path . $img_db['file_cap_tandatangan']);
							if (!$unlink) {
								$data['msg']['status'] = 'error';
								$data['msg']['content'] = 'Gagal menghapus gambar lama';
							}
						}
					}
					
					$new_name_cap = upload_file($path, $_FILES['file_cap_tandatangan']);
				}
	
				if ($new_name_ttd && $new_name_cap) {

					$data_db['file_tandatangan'] = $new_name_ttd;
					$data_db['file_cap_tandatangan'] = $new_name_cap;

					$query = $db->update('tandatangan', $data_db, 'id_tandatangan = ' . $_POST['id']);
					if ($query) {
						$data['msg']['status'] = 'ok';
						$data['msg']['content'] = 'Data berhasil disimpan';
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
		load_view('views/form.php', $data);
		
	case 'set-default':
		if (isset($_POST['submit'])) 
		{
			$data_db['gunakan'] = 0;
			$query = $db->update('tandatangan', $data_db);
			$query = $db->update('tandatangan', ['gunakan' => 1], 'id_tandatangan = ' . $_POST['id']);
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
function set_data() {
	$exp = explode('-', $_POST['tgl_tandatangan']);
	$tanggal = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
	$data_db['kota_tandatangan'] = $_POST['kota_tandatangan'];
	$data_db['nama_tandatangan'] = $_POST['nama_tandatangan'];
	$data_db['nip_tandatangan'] = $_POST['nip_tandatangan'];
	$data_db['tgl_tandatangan'] = $tanggal;
	$data_db['jabatan'] = $_POST['jabatan'];
	
	return $data_db;
	
}
function validate_form() {
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('kota_tandatangan', 'Kota Tanda Tangan', 'trim|required');
	$validation->setRules('nama_tandatangan', 'Nama Tanda Tangan', 'trim|required');
	$validation->setRules('nip_tandatangan', 'NIP Tanda Tangan', 'trim|required');
	$validation->setRules('tgl_tandatangan', 'Tgl. Tanda Tangan', 'trim|required');
	$validation->setRules('jabatan', 'NIP Tanda Tangan', 'trim|required');
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
	
	if ($_FILES['file_tandatangan']['name']) {
		$file_type = $_FILES['file_tandatangan']['type'];
		$allowed = ['image/png', 'image/jpeg', 'image/jpg'];
		
		if (!in_array($file_type, $allowed)) {
			$form_errors['file_tandatangan'] = 'Tipe file harus ' . join($allowed, ', ');
		}
		
		if ($_FILES['file_tandatangan']['size'] > 300 * 1024) {
			$form_errors['file_tandatangan'] = 'Ukuran file maksimal 300Kb';
		}
		
		$info = getimagesize($_FILES['file_tandatangan']['tmp_name']);
		if ($info[0] < 100 || $info[1] < 100) { //0 Width, 1 Height
			$form_errors['file_tandatangan'] = 'Dimensi file minimal: 100px x 100px';
		}
	}
	
	return $form_errors;
}