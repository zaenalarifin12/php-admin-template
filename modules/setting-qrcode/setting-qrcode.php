<?php
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

login_required();
$js[] = BASE_URL . 'assets/vendors/displace/displace.js';
$js[] = BASE_URL . 'themes/modern/assets/js/setting-qrcode.js';

$fields = ['version', 'ecc', 'size_module', 'padding', 'global_text', 'posisi_kartu', 'posisi_top', 'posisi_left'];
switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'preview':
		// echo '<pre>'; print_r($_GET); die;
		require BASE_PATH . 'libraries' . DS . 'vendors' . DS . 'qrcode' . DS . 'qrcode_extended.php';
		$height = $_GET['size_module'] % 2 ? $_GET['size_module'] : $_GET['size_module'] + 0.5;
		$qr = new QRCodeExtended();
		
		$ecc = ['L' => QR_ERROR_CORRECT_LEVEL_L
				, 'M' => QR_ERROR_CORRECT_LEVEL_M
				, 'Q' => QR_ERROR_CORRECT_LEVEL_Q
				, 'H' => QR_ERROR_CORRECT_LEVEL_H
			];
		$qr->setErrorCorrectLevel($ecc[$_GET['ecc']]);
		$qr->setTypeNumber($_GET['version']);
		$qr->addData($_GET['global_text']);
		$cek = $qr->checkError();
		if ($cek['status'] == 'success') {
			$qr->make();
			$position = 'top: ' . $_GET['posisi_top'] . 'px;left: ' . $_GET['posisi_left'] . 'px;';
			echo '<div class="qrcode-container" style="' . $position . 'padding:'.$_GET['padding'].'; background:#FFFFFF">' . $qr->saveHtml($_GET['size_module']) . '</div>';
		} else {
			echo '<div class="alert alert-warning">' . $cek['content'] . '</div>';
		}
		die;

	case 'index':
		
		$sql = 'SELECT * FROM layout_kartu WHERE gunakan = 1';
		$result = $db->query($sql)->row();
		$data['layout']	= $result;
		$data['background'] = [
				'background_depan' => $result['background_depan']
				,'background_belakang'  => $result['background_belakang']
			];
		
		$sql = 'SELECT * FROM setting_printer';
		$result = $db->query($sql)->result();
		$data['printer']	= $result[0];
		
		$exists = false;
		$sql = 'SELECT * FROM setting_qrcode';
		$query = $db->query($sql)->row();
		if ($query) {
			$exists= true;
			foreach($query as $key => $val) {
				$data[$key] = $val;
			}
		}
		
		if (!empty($_POST['submit'])) 
		{
			if ($module_role[$_SESSION['user']['id_role']]['update_data'] == 'all')
			{
				$form_errors = validate_form();
				if ($form_errors) {
					$data['msg']['status'] = 'error';
					$data['msg']['content'] = $form_errors;
				} else {
					// Logo Login
						foreach ($fields as $field) {
							$data_db[$field] = $_POST[$field];
						}
						
						if ($exists) {
							$query = $db->update('setting_qrcode', $data_db);
						} else {
							$query = $db->insert('setting_qrcode', $data_db);
						}
						if ($query) 
						{
							$data['msg']['status'] = 'ok';
							$data['msg']['content'] = 'Data berhasil disimpan';
							
							$sql = 'SELECT * FROM setting_qrcode';
							$query = $db->query($sql)->row();
							if ($query) {
								foreach($query as $key => $val) {
									$data[$key] = $val;
								}
							}
						} else {
							$data['msg']['status'] = 'error';
							$data['msg']['content'] = 'Data gagal disimpan';
						}
					}
			} else {
				$data['msg']['status'] = 'error';
				$data['msg']['content'] = 'Role anda tidak diperbolehkan melakukan perubahan';
			}	
		} 
				
		$data['title'] = 'Edit ' . $app_module['judul_module'];
		load_view('views/form.php', $data);
}

function validate_form() 
{
	require_once('libraries/form_validation.php');
	$validation = new FormValidation();
	$validation->setRules('version', 'Version', 'trim|required');
	$validation->setRules('ecc', 'ECC', 'trim|required');
	$validation->setRules('size_module', 'Size Module', 'trim|required');
	$validation->setRules('padding', 'Padding Tepi', 'trim|required');
	$validation->setRules('posisi_kartu', 'Posisi Kartu', 'trim|required');
	
	$validation->validate();
	$form_errors =  $validation->getMessage();
	
	return $form_errors;
}