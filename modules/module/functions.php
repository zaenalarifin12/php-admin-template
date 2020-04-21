<?php
function checkForm() 
{
	$error = [];
	if (trim($_POST['nama_menu']) == '') {
		$error[] = 'Nama menu harus diisi';
	}
	
	if (trim($_POST['url']) == '') {
		$error[] = 'Url harus diisi';
	}
	
	return $error;
}

function build_menu_list( $arr)
{
	// echo '<pre>'; print_r($arr); die;
	$menu = "\n" . '<ol class="dd-list">'."\r\n";

	foreach ($arr as $key => $val) 
	{
		// Check new
		$new = @$val['new'] == 1 ? '<span class="menu-baru">NEW</span>' : '';
		$icon = '';
		if ($val['icon']) {
			$icon = '<i class="'.$val['icon'].'"></i>';
			
		}
		
		$menu .= '<li class="dd-item" data-id="'.$val['menu_id'].'"><div class="dd-handle">'.$icon.'<span class="menu-title">'.$val['nama_menu'].'</span></div>';
		
		if (key_exists('children', $val))
		{ 	
			$menu .= build_menu_list($val['children'], ' class="submenu"');
		}
		$menu .= "</li>\n";
	}
	$menu .= "</ol>\n";
	return $menu;
}

function build_child($arr, $parent=0, &$list=[]) 
{
	foreach ($arr as $key => $val) 
	{
		$list[$parent][] = $val['id'];
		// echo $val['id'];
		if (key_exists('children', $val))
		{ 	
	// print_r($val['id']); die;
			build_child($val['children'], $val['id'], $list);
		}
	}
	
	
	return $list;
}