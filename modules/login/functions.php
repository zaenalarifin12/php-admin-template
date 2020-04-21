<?php
function check_user($username) 
{
	global $db;
	$query = $db->query('SELECT * FROM user WHERE username = ?', $username)->row();

	return $query;		
}

function check_login() {
	global $db;

	$error = false;
	$user = check_user($_POST['username']);
	
	if ($user) {
		if (!password_verify($_POST['password'],$user['password'])) {
			$error = true;
		}
	} else {
		$error = true;
	}
	
	if ($error) {
		return 'Username dan password tidak cocok';
	} else {
	
		if (!empty($_POST['remember']))
		{
			global $app_auth;
			$token = $app_auth->generateDbToken();
			$expired_time = 30*24*3600; // 1 month
					
			setcookie('remember', $token['selector'] . ':' . $token['external'], $expired_time, '/');
			
			$data = array ( 'id_user' => $user['id_user']
							, 'selector' => $token['selector']
							, 'token' => $token['db']
							, 'expires' => date('Y-m-d H:i:s', time() + $expired_time)
						);
			
			delete_auth_cookie($user['id_user']);
			insert_cookie($data);
		}
				
		$user_detail = $db->query('SELECT * FROM user 
									WHERE id_user = ' . $user['id_user']
								)->row();

		$_SESSION ['user'] = $user_detail;
		$_SESSION['logged_in'] = true;
		
		header('location:./');
	}
}

function get_user() 
{
	global $db;
	$sql = 'SELECT * FROM user';
	$result = $db->query($sql)->result();;
	return $result;
}

function check_cookie($selector) 
{
	global $db;
	$sql = 'SELECT u.email, ca.token, expires FROM user_cookie AS ca
			JOIN user AS u USING (id_user)
			WHERE selector = ?
					AND expires > "' . date('Y-m-d H:i:s') . '"';				
	return $db->query($sql, $selector)->result();
}

function delete_auth_cookie($id_user) 
{
	global $db;
	$sql = 'DELETE FROM user_cookie WHERE id_user = ?';						
	return $db->query($sql, $id_user);
}

function insert_cookie($data) {
	global $db;
	return $db->insert('user_cookie', $data);
}