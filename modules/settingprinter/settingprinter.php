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
			$result = $db->delete('setting_printer', ['id_setting_printer' => $_POST['id']]);
			// $result = true;
			if ($result) {
				$sql = 'SELECT COUNT(*) AS jml_data FROM setting_printer WHERE gunakan = 1';
				$jml_data = $db->query($sql)->row();
				if ($jml_data['jml_data'] == 0) {
					$sql = 'SELECT id_setting_printer FROM setting_printer ORDER BY id_setting_printer DESC LIMIT 1';
					$id = $db->query($sql)->row();
					if ($id) {
						$data_db['gunakan'] = 1;
						$query = $db->update('setting_printer', $data_db, 'id_setting_printer = ' . $id['id_setting_printer']);
					}
				}
				$data['msg'] = ['status' => 'ok', 'message' => 'Data berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data gagal dihapus'];
			}
		}
		$sql = 'SELECT * FROM setting_printer ORDER BY gunakan DESC';
		$data['result'] = $db->query($sql)->result();
		
		if (!$data['result']) {
			$data['msg']['status'] = 'error';
			$data['msg']['content'] = 'Data tidak ditemukan';
		}
		
		load_view('views/result.php', $data);
	
	case 'add': 
		$breadcrumb['Add'] = '';
		$data['msg'] = [];
		$data['title'] = 'Tambah ' . $app_module['judul_module'];
		
		if (isset($_POST['submit'])) 
		{
			$form_errors = validate_form();
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
		
				$data_db = set_data();
				$sql = 'SELECT COUNT(*) AS jml_data FROM setting_printer';
				$jml_data = $db->query($sql)->row();
				if ($jml_data['jml_data'] == 0) {
					$data_db['gunakan'] = 1;
				}
				$query = $db->insert('setting_printer', $data_db);
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['content'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Data gagal disimpan';
				}
			}
		}
		load_view('views/form.php', $data);
		
	case 'edit': 
			
		$breadcrumb['Edit'] = '';
		
		$sql = 'SELECT * FROM setting_printer WHERE id_setting_printer = ?';
		$result = $db->query($sql, trim($_GET['id']))->result();
		$data	= $result[0];
		
		$data['title'] = 'Edit ' . $app_module['judul_module'];

		// Submit
		$data['msg'] = [];
		if (isset($_POST['submit'])) 
		{
			$form_errors = validate_form();
			
			if ($form_errors) {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = $form_errors;
			} else {
		
				$data_db = set_data();
				$query = $db->update('setting_printer', $data_db, 'id_setting_printer = ' . $_POST['id']);
				
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['content'] = 'Data berhasil disimpan';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = 'Data gagal disimpan';
				}
			}
		}
		load_view('views/form.php', $data);
	case 'set-default':
	if (isset($_POST['submit'])) 
	{
		$data_db['gunakan'] = 0;
		$query = $db->update('setting_printer', $data_db);
		$query = $db->update('setting_printer', ['gunakan' => 1], 'id_setting_printer = ' . $_POST['id']);
		if ($query) {
			$data['msg']['status'] = 'ok';
			$data['msg']['content'] = 'Data berhasil diupdate';
			
		} else {
			$data['msg']['status'] = 'error';
			$data['msg']['content'] = 'Data gagal diupdate';
		}
		echo json_encode($data); 
		die;	
	}
}

function set_data() 
{
	$data_db['dpi'] = $_POST['dpi'];
	$data_db['margin_kiri'] = $_POST['margin_kiri'];
	$data_db['margin_atas'] = $_POST['margin_atas'];
	$data_db['margin_kartu_kanan'] = $_POST['margin_kartu_kanan'];
	$data_db['margin_kartu_bawah'] = $_POST['margin_kartu_bawah'];
	$data_db['margin_kartu_depan_belakang'] = $_POST['margin_kartu_depan_belakang'];
	
	return $data_db;
}

function validate_form() {
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('dpi', 'DPI', 'required');
	$validation->setRules('margin_kiri', 'Margin Kiri', 'required');
	$validation->setRules('margin_atas', 'Margin Atas', 'required');
	$validation->setRules('margin_kartu_kanan', 'Margin Kartu Kanan', 'required');
	$validation->setRules('margin_kartu_bawah', 'Margin Kartu Bawah', 'required');
	$validation->setRules('margin_kartu_depan_belakang', 'Margin Kartu Depan Belakang', 'required');
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
	
	return $form_errors;
}