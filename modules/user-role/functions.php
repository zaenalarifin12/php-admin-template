<?php
function checkForm() 
{
	$error = true;
	foreach ($_POST as $key => $val) {
		$exp = explode('_', $key);
		if ($exp[0] == 'role') {
			$error = false;
		}
	}
	
	if ($error) {
		$error = 'Role belum dipilih';
	}
	return $error;
}