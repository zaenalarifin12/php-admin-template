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
		<form method="post" action="" id="form-setting">
			<div class="tab-content" id="myTabContent">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Color Scheme</label>
					<div class="col-sm-5 form-inline">
						<ul id="color-scheme" class="color-scheme-options">
							<?php
							$list = ['blue-dark', 'blue', 'green', 'grey', 'purple', 'red', 'yellow'];
							foreach ($list as $val) {
								$check = @$color_scheme ==  $val ? '<i class="fa fa-check theme-check"></i>' : '';
								echo '<li><a href="javascript:void(0)" class="'.$val.'-theme">' . $check . '</a></li>';
							}
							?>	
						</ul>
						<input type="hidden" name="color_scheme" id="input-color-scheme" value="<?=set_value('logo_background_color', @$color_scheme)?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Background Logo</label>
					<div class="col-sm-5 form-inline">
						<?=options(['name' => 'logo_background_color', 'id' => 'logo-background-color'], ['default' => 'Sesuai Color Scheme', 'dark' => 'Dark'], set_value('logo_background_color', @$logo_background_color))?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Sidebar Color</label>
					<div class="col-sm-5 form-inline">
						<?=options(['name' => 'sidebar_color', 'id' => 'sidebar-color'], ['light' => 'Light', 'dark' => 'Dark'],  set_value('sidebar_color', @$sidebar_color))?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Font Family</label>
					<div class="col-sm-5 form-inline">
						<?=options(['name' => 'font_family', 'id' => 'font'], ['open-sans' => 'Open Sans (Default)', 'poppins' => 'Poppins', 'arial' => 'Arial', 'verdana' => 'Verdana'], set_value('font_family', @$font_family))?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Font Size</label>
					<div class="col-sm-3">
						<div class="range-slider-test">
							<?php
							$value = @$font_size ? $font_size : @$_POST['font_size'];
							?>
						  <input class="range-slider" id="font-size" type="range" step="0.5" name="font_size" id="font-size" value="<?=$value?>" min="10" max="18">
						  <?php
						  $pos_left = (($value - 10 ) * 33);
						  ?>
						  <output for="font-size" style="left:<?=$pos_left?>px"><?=$value?></output>px
						</div>
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