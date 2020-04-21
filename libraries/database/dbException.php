<?php
/**
*	Database Exception
*	@author Agus Prawoto Hadi
*	@website https://webdev.id
* 	@copyright 2019
*/

class dbException
{
	public function __construct($e, $text = '') {
		
		$title = 'Database Error';
		$content = '';
		if ($text) {
			$content .= '<p>' . $text . '</p>';
		}
		$content .= '<p><strong>Error</strong> : ' . $e->getMessage() . '</p>';
		include 'display_error.php';
		die;
	}
}

?>