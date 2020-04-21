<?php
/**
Functions
https://webdev.id
*/

/* Create breadcrumb
$data: title as key, and url as value */ 

function breadcrumb($data) 
{
	$separator = '&raquo;';
	echo '<nav aria-label="breadcrumb">
  <ol class="breadcrumb">';
	foreach ($data as $title => $url) {
		if ($url) {
			echo '<li class="breadcrumb-item"><a href="'.$url.'">'.$title.'</a></li>';
		} else {
			echo '<li class="breadcrumb-item active" aria-current="page">'.$title.'</li>';
		}
	}
	echo '
  </ol>
</nav>';
}

function nama_bulan() 
{
	return [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; 
}

function format_tanggal($date) 
{
	if ($date == '0000-00-00')
		return $date;
	
	$bulan = nama_bulan();
	$exp = explode('-', $date);
	return $exp[2] . ' ' . $bulan[ ($exp[1] * 1) ] . ' ' . $exp[0]; // * untuk mengubah 02 menjadi 2
}

function prepare_datadb($data) {
	foreach ($data as $field) {
		$result[$field] = $_POST[$field];
	}
	return $result;
}

function current_url() {
	return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function theme_url() {
	global $config;
	return $config['base_url'] . 'themes/modern' ;
}

function module_url($action = false) {
	global $config;
	
	$url = $config['base_url'];
	if (empty($_GET['module'])) {
		$module = $config['default_module'];
	} else {
		$module = $_GET['module'];
	}
	$url .= $module;
		
	if (!empty($_GET['action']) && $_GET['action'] != 'index' && $action) {
		$url .= $_GET['action'];
	}
	// return $config['base_url'] . '?module=' . $_GET['module']; 
	return $url;
}

function cek_hakakses($action, $param = false) 
{
	global $list_action;
	global $app_module;
	
	$allowed = $list_action[$action];
	if ($allowed == 'no') {
		// echo 'Anda tidak berhak mengakses halaman ini ' . $app_module['judul_module']; die;
		$app_module['nama_module'] = 'error';
		load_view('views/error.php', ['status' => 'error', 'message' => 'Anda tidak berhak mengakses halaman ini']);
	}
}
/*
	$message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
	show_message($message);
	
	$msg = ['status' => 'ok', 'content' => 'Data berhasil disimpan'];
	show_message($msg['content'], $msg['status']);
	
	$error = ['role_name' => ['Data sudah ada di database', 'Data harus disi']];
	show_message($error, 'error');
	
	$error = ['Data sudah ada di database', 'Data harus disi'];
	show_message($error, 'error');
*/
function show_message($message, $type = null, $dismiss = true) {
	//<ul class="list-error">
	if (is_array($message)) {
		
		// $message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
		if (key_exists('status', $message)) 
		{
			$type = $message['status'];
			if (is_array($message['message'])) {
				$message_content = $message['message'];
			} else {
				$message_content[] = $message['message'];
			}
		
		} else {
			if (is_array($message)) {
				foreach ($message as $key => $val) {
					if (is_array($val)) {
						foreach ($val as $key2 => $val2) {
							$message_content[] = $val2;
						}
					} else {
						$message_content[] = $val;
					}
				}
			}
		}
		// print_r($message_content);
		if (count($message_content) > 1) {
			
			$message_content = recursive_loop($message_content);
			$message = '<ul><li>' . join($message_content, '</li><li>') . '</li></ul>';
		}
		else {
			// echo '<pre>'; print_r($message_content);
			$message_content = recursive_loop($message_content);
			// echo '<pre>'; print_r($message_content);
			$message = $message_content[0];
		}
	}
	
	switch ($type) {
		case 'error' :
			$alert_type = 'danger';
			break;
		case 'warning' :
			$alert_type = 'danger';
			break;
		default:
			$alert_type = 'success';
			break;
	}
	$close_btn = '';
	if ($dismiss) {
		$close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'; 
	}
	
	echo '<div class="alert alert-dismissible alert-'.$alert_type.'" role="alert">'. $message . $close_btn . '</div>';
}

function recursive_loop($array, $result = []) {
	// echo '<pre>'; print_r($array);
	foreach ($array as $val) {
		if (is_array($val)) {
			$result = recursive_loop($val, $result);
		} else {
			$result[] = $val;
		}
		// echo '<pre>'; print_r($result);
	}
	return $result;
}


function show_alert($message, $title = null, $dismiss = true) {

	if (is_array($message)) 
	{
		// $message = ['status' => 'ok', 'message' => 'Data berhasil disimpan'];
		if (key_exists('status', $message)) {
			$type = $message['status'];
		}

		if (key_exists('message', $message)) {
			$message = $message['message'];
		}
		
		if (is_array($message)) {
			foreach ($message as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $key2 => $val2) {
						$message_content[] = $val2;
					}
				} else {
					$message_content[] = $val;
				}
			}
			
			if (count($message_content) > 1) {
				$message = '<ul><li>' . join($message_content, '</li><li>') . '</li></ul>';
			}
			else {
				$message = $message_content[0];
			}
		}
	}
	
	if (!$title) {
		switch ($type) {
			case 'error' :
				$title = 'ERROR !!!';
				$icon_type = 'error';
				break;
			case 'warning' :
				$title = 'WARNIG !!!';
				$icon_type = 'error';
				break;
			default:
				$title = 'SUKSES !!!';
				$icon_type = 'success';
				break;
		}
	}
	
	echo '<script type="text/javascript">
			Swal.fire({
				title: "'.$title.'",
				html: "'.$message.'",
				type: "'.$icon_type.'",
				showCloseButton: '.$dismiss.',
				confirmButtonText: "OK"
			})
		</script>';
}

function set_value($field_name, $default = '') 
{
	if (!empty($_POST[$field_name])) {
		return $_POST[$field_name];
	}

	return $default;
}

function current_action_url() {
	global $config;
	return $config['base_url'] . '?module=' . $_GET['module'] . '&action=' . $_GET['action']; 
}


function get_menu_db ($aktif = 'all', $show_all = false) 
{
	global $db;
	global $app_module;
	
	$result = [];
	$nama_module = $app_module['nama_module'];
	$where = ' ';
	$where_aktif = '';
	if ($aktif != 'all') {
		$where_aktif = ' AND aktif = '.$aktif;
	}
	
	$role = '';
	if (!$show_all) {
		$role = ' AND id_role = ' . $_SESSION['user']['id_role'];
	}
	
	$sql = 'SELECT * FROM menu 
				LEFT JOIN menu_role USING (id_menu)
				LEFT JOIN module USING (id_module)
			WHERE 1 = 1 ' . $role
				. $where_aktif.' 
			ORDER BY urut';
	// echo $sql; die;
	$db->query($sql);
	
	$current_id = '';
	while ($row = $db->fetch()) 
	{
		
		$result[$row['id_menu']] = $row;
		$result[$row['id_menu']]['highlight'] = 0;
		$result[$row['id_menu']]['depth'] = 0;

		if ($nama_module == $row['nama_module']) {
			
			$current_id = $row['id_menu'];
			$result[$row['id_menu']]['highlight'] = 1;
		}
		
	}
	// echo '<pre>'; print_r($result);
	
	if ($current_id) {
		menu_current($result, $current_id);
	}
	
	return $result;
}

function menu_current( &$result, $current_id) 
{
	$parent = $result[$current_id]['id_parent'];

	$result[$parent]['highlight'] = 1; // Highlight menu parent
	if (@$result[$parent]['id_parent']) {
		menu_current($result, $parent);
	}
}

function menu_list($result)
{
	$refs = array();
	$list = array();
	// echo '<pre>'; print_r($result);
	foreach ($result as $key => $data)
	{
		if (!$key || empty($data['id_menu'])) // Highlight OR No parent
			continue;
		
		$thisref = &$refs[ $data['id_menu'] ];
		foreach ($data as $field => $value) {
			$thisref[$field] = $value;
		}

		// no parent
		if ($data['id_parent'] == 0) {
			
			$list[ $data['id_menu'] ] = &$thisref;
		} else {
			
			$thisref['depth'] = ++$refs[ $data['id_menu']]['depth'];			
			$refs[ $data['id_parent'] ]['children'][ $data['id_menu'] ] = &$thisref;
		}
	}
	set_depth($list);	
	return $list;
}

function set_depth(&$result, $depth = 0) {
	foreach ($result as $key => &$val) 
	{
		$val['depth'] = $depth;
		if (key_exists('children', $val)) {
			set_depth($val['children'], $val['depth'] + 1);
		}
	}
}

function build_menu( $arr, $submenu = false)
{
	global $app_module;
	$menu = "\n" . '<ul'.$submenu.'>'."\r\n";

	foreach ($arr as $key => $val) 
	{
	// echo '<pre>ff'; print_r($arr); die;
		if (!$key)
			continue;
	
		// Check new
		$new = '';
		if (key_exists('new', $val)) {
			$new = $val['new'] == 1 ? '<span class="menu-baru">NEW</span>' : '';
		}
		$arrow = key_exists('children', $val) ? '<span class="pull-right-container">
								<i class="fa fa-angle-left arrow"></i>
							</span>' : '';
		$has_child = key_exists('children', $val) ? 'has-children' : '';
		
		if ($has_child) {
			$url = '#';
			$onClick = ' onclick="javascript:void(0)"';
		} else {
			$onClick = '';
			$url = $val['url'];
		}
		
		// class attribute for <li>
		$class_li = [];		
		if ($app_module['nama_module'] == $val['nama_module']) {
			$class_li[] = 'tree-open';
		}
		
		if ($val['highlight']) {
			$class_li[] = 'highlight tree-open';
		}
		
		if ($class_li) {
			$class_li = ' class="' . join($class_li, ' ') . '"';
		} else {
			$class_li = '';
		}
		
		// Class attribute for <a>, children of <li>
		$class_a = ['depth-' . $val['depth']];
		if ($has_child) {
			$class_a[] = 'has-children';
		}
		
		$class_a = ' class="' . join($class_a, ' ') . '"';
		
		// Menu icon
		$menu_icon = '';
		if ($val['class']) {
			$menu_icon = '<i class="sidebar-menu-icon ' . $val['class'] . '"></i>';
		}

		// Menu
		$menu .= '<li'. $class_li . '>
					<a '.$class_a.' href="'. BASE_URL . $url.'"'.$onClick.'>'.
						$menu_icon.
						$val['nama_menu'] .
						$arrow.
					'</a>'.$new;
		
		if (key_exists('children', $val))
		{ 	
			$menu .= build_menu($val['children'], ' class="submenu"');
		} 
		$menu .= "</li>\n";
	}
	$menu .= "</ul>\n";
	return $menu;
}

function create_image_mime ($tipe_file, $newfile)
{
	switch ($tipe_file)
	{
		case "image/gif":
			return imagecreatefromgif($newfile);
			
		case "image/png":
			return imagecreatefrompng($newfile);
			
		case "image/bmp":
			return imagecreatefrombmp($newfile);
			
		default:
			return imagecreatefromjpeg($newfile);		
	}
}
	
function create_image ($tipe_file, $resized_img, $newfile)
{
	switch ($tipe_file)
	{
		case "image/gif":
			return imagegif ($resized_img,$newfile, 85);
			
		case "image/png":
			imagesavealpha($resized_img, true);
			$color = imagecolorallocatealpha($resized_img, 0,0,0,127);
			imagefill($resized_img, 0,0, $color);
			return imagepng ($resized_img,$newfile, 9);
			
		case "image/bmp":
			return imagecreatefrombmp($newfile);
			
		default:
			return imagejpeg ($resized_img,$newfile, 85);
			
	}
}

function get_filename($file_name, $path) {
	
	$file_name_path = $path . $file_name;
	if ($file_name != "" && file_exists($file_name_path))
	{
		$file_ext = strrchr($file_name, '.');
		$file_basename = substr($file_name, 0, strripos($file_name, '.'));
		$num = 1;
		while (file_exists($file_name_path)){
			$file_name = $file_basename."($num)".$file_ext;
			$num++;
			$file_name_path = $path . $file_name;
		}
		
		return $file_name;
	}
	return $file_name;
}

function upload_image($path, $file, $max_w = 500, $max_h = 500) 
{
	
	$file_type = $file['type'];
	$new_name =  get_filename(stripslashes($file['name']), $path); ;
	$move = move_uploaded_file($file['tmp_name'], $path . $new_name);
	
	$save_image = false;
	if ($move) {
		$dim = image_dimension($path . $new_name, $max_w, $max_h);
		$save_image = save_image($path . $new_name, $file_type, $dim[0], $dim[1]);
	}
	
	if ($save_image)
		return $new_name;
	else
		return false;
}

function image_dimension($images, $maxw=null, $maxh=null)
{
	if($images)
	{
		$img_size = @getimagesize($images);
		$w = $img_size[0];
		$h = $img_size[1];
		$dim = array('w','h');
		foreach($dim AS $val){
			$max = "max{$val}";
			if(${$val} > ${$max} && ${$max}){
				$alt = ($val == 'w') ? 'h' : 'w';
				$ratio = ${$alt} / ${$val};
				${$val} = ${$max};
				${$alt} = ${$val} * $ratio;
			}
		}
		return array($w,$h);
	}
}

function save_image($image, $file_type, $w, $h) 
{
	$img_size = @getimagesize($image);
	
	$resized_img = imagecreatetruecolor($w,$h);
	$new_img = create_image_mime($file_type, $image);
	imagecopyresized($resized_img, $new_img, 0, 0, 0, 0, $w, $h, $img_size[0], $img_size[1]);
	$do = create_image($file_type, $resized_img, $image);
	ImageDestroy ($resized_img);
	ImageDestroy ($new_img);
	return $do;
}

function upload_file($path, $file) 
{
	$new_name =  get_filename(stripslashes($file['name']), $path); ;
	$move = move_uploaded_file($file['tmp_name'], $path . $new_name);
	if ($move) 
		return $new_name;
	else
		return false;
}

function get_dimensi_kartu($ori_panjang, $ori_lebar, $dpi) {
	// print_r($ori_panjang); die;
	$px = 0.393700787; 
	$panjang = $ori_panjang * $dpi * $px;
	$lebar = $ori_lebar * $dpi * $px;
	return ['w' => $panjang, 'h' => $lebar];
}

function generateQRCode($version, $ecc, $text, $module_width) {
	
	require BASE_PATH . 'libraries' . DS . 'vendors' . DS . 'qrcode' . DS . 'qrcode_extended.php';
	$qr = new QRCodeExtended();
	$ecc_code = ['L' => QR_ERROR_CORRECT_LEVEL_L
		, 'M' => QR_ERROR_CORRECT_LEVEL_M
		, 'Q' => QR_ERROR_CORRECT_LEVEL_Q
		, 'H' => QR_ERROR_CORRECT_LEVEL_H
	];
	$qr->setErrorCorrectLevel($ecc_code[$ecc]);
	$qr->setTypeNumber($version);
	$qr->addData($text);
	$qr->make();
	return $qr->saveHtml($module_width);
}