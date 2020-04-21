<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			include 'helpers/html.php';
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		<form method="post" action="" id="form-setting" enctype="multipart/form-data">
			<div class="tab-content">
				<h5>Login</h5>
				<hr/>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Logo Login</label>
					<div class="col-sm-5">
						<?php
						if (!empty($logo_login) && file_exists($config['images_path'] . $logo_login))
						echo '<div style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['images_path'] . $logo_login . '"/></div>';
						
						?>
						<input type="file" class="file" name="logo_login">
							<?php if (!empty($form_errors['logo_login'])) echo '<small class="alert alert-danger">' . $form_errors['logo_login'] . '</small>'?>
							<small class="form-text text-muted"><strong>Gunakan file PNG transparan, lebar 220px</strong>. Maksimal 300Kb, Minimal 50px x 50px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
					
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Background Logo</label>
					<div class="col-sm-5 form-inline">
						<input name="background_logo" class="form-control colorpicker" value="<?=set_value(@$_POST['background_logo'], @$background_logo)?>" />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Button</label>
					<div class="col-sm-5">
						<ul class="list-inline list-btn-login">
							<?php
							$list = ['btn-primary', 'btn-secondary', 'btn-success', 'btn-danger', 'btn-warning', 'btn-info', 'btn-light', 'btn-dark'];
							foreach ($list as $val) {
								$check = @$btn_login == $val ? '<i class="fa fa-check check"></i>' : ''; 
								echo '<li class="list-inline-item"><a data-class="'. $val . '" href="javascript:void(0)" class="theme-btn-login btn '.$val.'">' . $check . '</a></li>';
							}
							?>	
						</ul>
						<input type="hidden" name="btn_login" value="<?=set_value(@$_POST['btn_login'], @$btn_login)?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Footer</label>
					<div class="col-sm-5">
						<textarea class="form-control" name="footer_login"><?=set_value(@$_POST['footer_login'], @$footer_login)?></textarea>
					</div>
				</div>
				<h5>Website</h5>
				<hr/>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Web</label>
					<div class="col-sm-5">
						<textarea class="form-control" name="judul_web"><?=set_value(@$_POST['judul_web'], @$judul_web)?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Deskripsi Web</label>
					<div class="col-sm-5">
						<textarea class="form-control" name="deskripsi_web"><?=set_value(@$_POST['deskripsi_web'], @$deskripsi_web)?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Fav Icon</label>
					<div class="col-sm-5">
						<?php
						if (!empty($favicon) && file_exists($config['images_path'] . $favicon))
						echo '<div style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['images_path'] . $favicon . '"/></div>';
						
						?>
						<input type="file" class="file" name="favicon">
							<?php if (!empty($form_errors['favicon'])) echo '<small class="alert alert-danger">' . $form_errors['favicon'] . '</small>'?>
							<small class="form-text text-muted"><strong>Gunakan file PNG transparan, width dan height sama, misal: 64px x 64px</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Logo Aplikasi</label>
					<div class="col-sm-5">
						<?php
						if (!empty($logo_app) && file_exists($config['images_path'] . $logo_app))
						echo '<div style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['images_path'] . $logo_app . '"/></div>';
						
						?>
						<input type="file" class="file" name="logo_app">
							<?php if (!empty($form_errors['logo_app'])) echo '<small class="alert alert-danger">' . $form_errors['logo_app'] . '</small>'?>
							<small class="form-text text-muted"><strong>Gunakan file PNG transparan, lebar maksimal 150px</strong>. Maksimal 300Kb, Minimal 50px x 50px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Background Logo</label>
					<div class="col-sm-5">
						Ubah di menu setting tampilan
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Footer</label>
					<div class="col-sm-5">
						<textarea class="form-control" name="footer_app"><?=set_value(@$_POST['footer_app'], @$footer_app)?></textarea>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-5">
						<button type="submit" name="submit" id="btn-submit" value="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>