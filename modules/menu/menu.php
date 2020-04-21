<?php
login_required();
/* echo '<pre>';
print_r($_SESSION); */
$site_title = 'Home Page';
$restrict_function = array('checkForm');

$styles[] = $config['base_url'] . 'assets/vendors/jquery-nestable/jquery.nestable.min.css?r='.time();
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-modal.css?r=' . time();
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-fapicker.css?r=' . time();
$styles[] = $config['base_url'] . 'assets/vendors/wdi/wdi-loader.css?r=' . time();
$styles[] = $config['base_url'] . 'assets/vendors/bulma-switch/bulma-switch.min.css?r=' . time();
$js[] = $config['base_url'] . 'assets/vendors/wdi/wdi-fapicker.js?r=' . time();
$js[] = THEME_URL . 'assets/js/admin-menu.js';
$js[] = $config['base_url'] . 'assets/vendors/jquery-nestable/jquery.nestable.js?r=' . time();
// $js[] = $config['base_url'] . 'assets/vendors/jquery-nestable/jquery.nestable-edit.js?r=' . time();
$js[] = $config['base_url'] . 'assets/vendors/js-yaml/js-yaml.min.js?r=' . time();
$js[] = $config['base_url'] . 'assets/vendors/jquery-nestable/jquery.wdi-menueditor.js?r=' . time();


include 'functions.php';

switch ($_GET['action']) 
{
	default: 
		action_notfound();
		
	// INDEX 
	case 'index':
		
		// SUBMIT
		$menu_updated = [];
		$msg = [];
		if (!empty($_POST['submit'])) 
		{
			$json = json_decode(trim($_POST['data']), true);
			$array = build_child($json);
			
			foreach ($array as $id_parent => $arr) {
				foreach ($arr as $key => $id_menu) {
					$list_menu[$id_menu] = ['id_parent' => $id_parent, 'urut' => ($key + 1)];
				}
			}
			// echo '<pre>'; print_r($list_menu);die;
			$result = $db->query('SELECT * FROM menu')->result();
			foreach ($result as $key => $row) 
			{
				$update = [];
				if ($list_menu[$row['id_menu']]['id_parent'] != $row['id_parent']) {
					$id_parent =  $list_menu[$row['id_menu']]['id_parent'] == 0 ? NULL : $list_menu[$row['id_menu']]['id_parent'];
					$update['id_parent'] = $id_parent;
				}
				
				if ($list_menu[$row['id_menu']]['urut'] != $row['urut']) {
					$update['urut'] = $list_menu[$row['id_menu']]['urut'];
				}
				
				if ($update) {
					$query = $db->update('menu', $update, 'id_menu=' . $row['id_menu']);
					if ($query) {
						$menu_updated[$row['id_menu']] = $row['id_menu'];
					}
				}
			}
			
			if ($menu_updated) {
				$msg['status'] = 'ok';
				$msg['content'] = 'Menu berhasil diupdate';
			} else {
				$msg['status'] = 'warning';
				$msg['content'] = 'Tidak ada menu yang diupdate';
			}
		}
		// End Submit

		require_once('includes/functions.php');
		$result = get_menu_db('all', true);
		$list_menu = menu_list($result);
		// echo '<pre>'; print_r($result); die;
		$data['list_menu'] = build_menu_list($list_menu); 
		$data['list_module'] = 	$db->query('SELECT * FROM module LEFT JOIN module_status USING(id_module_status)')->result();
		$data['role'] = 	$db->query('SELECT * FROM role')->result();
		$data['msg'] = $msg;
		
		$bredcrumb['Home'] = $config['base_url'];
		$bredcrumb['Data Gedung'] = $config['base_url'];
		$bredcrumb['Add'] = '';
		
		load_view('views/form.php', $data);

	// EDIT
	case 'edit':
	
		global $db;	
		
		// Submit
		$data['msg'] = [];
		if (isset($_POST['nama_menu'])) 
		{
			$error = checkForm();
			if ($error) {
				$data['msg']['status'] = 'error';
				$data['msg']['message'] = '<ul class="list-error"><li>' . join($error, '</li><li>') . '</li></ul>';
			} else {
				$data_db['nama_menu'] = $_POST['nama_menu'];
				$data_db['id_module'] = $_POST['id_module'];
				$data_db['url'] = $_POST['url'];
				if (empty($_POST['aktif'])) {
					$data_db['aktif'] = 0;
				} else {
					$data_db['aktif'] = 1;
				}
				
				if ($_POST['use_icon']) {
					$data_db['class'] = $_POST['icon_class'];
				} else {
					$data_db['class'] = NULL;
				}
				
				if (empty($_POST['id'])) {
					$query = $db->insert('menu', $data_db);
					$last_id = $db->lastInsertId();
					$message = 'Menu berhasil ditambahkan';
					$data['msg']['id_menu'] = $last_id;
				} else {
					$query = $db->update('menu', $data_db, 'id_menu = ' . $_POST['id']);
					$message = 'Menu berhasil diupdate';
				}
				
				$query = true;
				if ($query) {
					$data['msg']['status'] = 'ok';
					$data['msg']['message'] = $message;
					// $data['msg']['message'] = 'Menu berhasil diupdate';
				} else {
					$data['msg']['status'] = 'error';
					$data['msg']['message'] = 'Data gagal disimpan';
					$data['msg']['error_query'] = true;
				}	
			}
			echo json_encode($data['msg']);
			exit();
		}
		break;
	
	case 'delete':
		$result = $db->delete('menu', ['id_menu' => $_POST['id']]);
		// $result = false;
		if ($result) {
			$message = ['status' => 'ok', 'message' => 'Data menu berhasil dihapus'];
			echo json_encode($message);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Data menu gagal dihapus']);
		}
		break;
		
	case 'menu_detail':
		$sql = 'SELECT * FROM menu WHERE id_menu = ?';
		$result = $db->query($sql, $_GET['id'])->row();
		if (!empty($_GET['ajax'])) {
			echo json_encode($result);
		}
		break;
}