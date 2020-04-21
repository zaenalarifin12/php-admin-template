<?php
/**
*	Developed by: Agus Prawoto Hadi
*	Website		: www.jagowebdev.com
*	Year		: 2020
*/

login_required();
$js[] = BASE_URL . 'themes/modern/assets/js/cetakkartu.js';
$site_title = 'Home Page';
switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		cek_hakakses('read_data');
		
		if (!empty($_POST['delete'])) 
		{
			$result = $db->delete('gedung', ['id_gedung' => $_POST['id']]);
			// $result = true;
			if ($result) {
				$data['msg'] = ['status' => 'ok', 'message' => 'Data gedung berhasil dihapus'];
			} else {
				$data['msg'] = ['status' => 'error', 'message' => 'Data gedung gagal dihapus'];
			}
		}
		
		$where = '';
		if ($list_action['read_data'] == 'own') {
			$where = ' WHERE id_user_input = ' . $_SESSION['user']['id_user'];
		}
		
		$sql = 'SELECT * FROM mahasiswa' . $where;
		$data['result'] = $db->query($sql)->result();
		
		load_view('views/result.php', $data);
		
	case 'print':
		
		$data['setting_web'] = $setting_web;
		$data['app_module'] = $app_module;
		
		$data['id'] = $_GET['id'];
		$sql = 'SELECT * FROM layout_kartu WHERE gunakan = 1';
		$result = $db->query($sql)->row();
		$data['layout']	= $result;
		
		$sql = 'SELECT * FROM setting_qrcode';
		$result = $db->query($sql)->row();
		$data['qrcode']	= $result;
		
		$sql = 'SELECT * FROM setting_printer WHERE gunakan = 1';
		$result = $db->query($sql)->row();
		$data['printer']	= $result;
		
		$sql = 'SELECT * FROM tandatangan WHERE gunakan = 1';
		$result = $db->query($sql)->row();
		$data['ttd']	= $result;
		
		foreach ($data['id'] as $key => $val) {
			$sql = 'SELECT * FROM mahasiswa WHERE id_mahasiswa = ?';
			$result = $db->query($sql, trim($val))->result();
			$data['nama'][$val]	= $result[0];
		}
		
		$view = load_view('views/cetak.php', $data, true);
		echo $view;
	die;
}