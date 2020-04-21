	<div class="copyright">
		<?php
			$footer_login = $setting_web['footer_login'] ? str_replace('{{YEAR}}', date('Y'), $setting_web['footer_login']) : '';
			echo $footer_login;
		?>
	</div>
	</div><!-- login container -->
</body>
</html>