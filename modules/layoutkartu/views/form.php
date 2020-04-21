<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			include 'helpers/html.php';
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => module_url() . '?action=edit',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data'
			]);
			
			echo btn_label(['class' => 'btn btn-light btn-xs',
				'url' => module_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar Kartu'
			]);
		?>
		<hr/>
		<?php
		
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
			<div class="tab-content" id="myTabContent">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Layout</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="nama_layout" value="<?=set_value('nama_layout', @$nama_layout)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Panjang (cm)</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="panjang" value="<?=set_value('panjang', @$panjang)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Lebar (cm)</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="lebar" value="<?=set_value('lebar', @$lebar)?>"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Berlaku</label>
					<div class="col-sm-5 form-inline">
						<?php echo options(['name' => 'berlaku'], [1=>1,2=>2,3=>3,4=>4,5=>5], @$berlaku); ?>&nbsp;Tahun sejak tanggal terbit
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Background Depan</label>
					<div class="col-sm-5">
						<?php 
						// echo '<pre>'; print_r($_FILES);
						$file_background_depan = @$background_depan;
						if (!empty($file_background_depan) && file_exists($config['kartu_path'] . $file_background_depan))
						echo '<div class="list-foto" style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['kartu_path'] . $file_background_depan . '"/></div>';
						
						?>
						<input type="file" class="file" name="background_depan">
							<?php if (!empty($form_errors['background_depan'])) echo '<small class="alert alert-danger">' . $form_errors['background_depan'] . '</small>'?>
							<small class="small" style="display:block">Maksimal 300Kb, Minimal 100px x 100px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Background Belakang</label>
					<div class="col-sm-5">
						<?php 
						$file_background_belakang = @$background_belakang;
						if (!empty($file_background_belakang) && file_exists($config['kartu_path'] . $file_background_belakang))
						echo '<div class="list-foto" style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['kartu_path'] . $file_background_belakang . '"/></div>';
						
						?>
						<input type="file" class="file" name="background_belakang">
							<?php if (!empty($form_errors['background_belakang'])) echo '<small class="alert alert-danger">' . $form_errors['background_belakang'] . '</small>'?>
							<small class="small" style="display:block">Maksimal 300Kb, Minimal 100px x 100px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-5">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>