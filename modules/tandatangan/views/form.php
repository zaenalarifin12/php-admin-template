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
				'label' => 'Daftar Tanda Tangan'
			]);
		?>
		<hr/>
		<?php
		
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		if (@$tgl_tandatangan) {
			$exp = explode('-', $tgl_tandatangan);
			$tgl_tandatangan = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
		}
		?>
		<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
			<div class="tab-content" id="myTabContent">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Kota Tanda Tangan</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="kota_tandatangan" value="<?=set_value('kota_tandatangan', @$kota_tandatangan)?>"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Tanda Tangan</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="nama_tandatangan" value="<?=set_value('nama_tandatangan', @$nama_tandatangan)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">NIP Tanda Tangan</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="nip_tandatangan" value="<?=set_value('nip_tandatangan', @$nip_tandatangan)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Jabatan</label>
					<div class="col-sm-5">
						<input class="form-control" type="text" name="jabatan" value="<?=set_value('jabatan', @$jabatan)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Tgl. Tanda Tangan</label>
					<div class="col-sm-5">
						<input class="form-control date-picker" type="text" name="tgl_tandatangan" value="<?=set_value('tgl_tandatangan', @$tgl_tandatangan)?>" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Tanda Tangan</label>
					<div class="col-sm-5">
						<?php 
						$value_tandatangan = @$_FILES['file_tandatangan']['name'] ?: @$file_tandatangan;
						if (!empty($value_tandatangan) && file_exists($config['kartu_path'] . $value_tandatangan))
						echo '<div class="list-foto" style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['kartu_path'] . $value_tandatangan . '"/></div>';
						
						?>
						<input type="file" class="file" name="file_tandatangan">
							<?php if (!empty($form_errors['file_tandatangan'])) echo '<small class="alert alert-danger">' . $form_errors['file_tandatangan'] . '</small>'?>
							<small class="small" style="display:block">Maksimal 300Kb, Minimal 100px x 100px, Tipe file: .JPG, .JPEG, .PNG</small>
						<div class="upload-img-thumb"><span class="img-prop"></span></div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Cap Tanda Tangan</label>
					<div class="col-sm-5">
						<?php 
						$value_cap_tandatangan = @$_FILES['file_cap_tandatangan']['name'] ?: @$file_cap_tandatangan;
						if (!empty($value_cap_tandatangan) && file_exists($config['kartu_path'] . $value_cap_tandatangan))
						echo '<div class="list-foto" style="margin:inherit;margin-bottom:10px"><img src="'.BASE_URL. $config['kartu_path'] . $value_cap_tandatangan . '"/></div>';
						
						?>
						<input type="file" class="file" name="file_cap_tandatangan">
							<?php if (!empty($form_errors['file_cap_tandatangan'])) echo '<small class="alert alert-danger">' . $form_errors['file_cap_tandatangan'] . '</small>'?>
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