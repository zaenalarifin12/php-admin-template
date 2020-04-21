<?php
require_once('includes/functions.php');
require_once('helpers/html.php');?>

<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php
		require_once 'helpers/html.php';
		echo btn_label(['class' => 'btn btn-success btn-xs',
			'url' => module_url() . '/edit',
			'icon' => 'fa fa-plus',
			'label' => 'Tambah Module'
		]);
		
		echo btn_label(['class' => 'btn btn-light btn-xs',
			'url' => module_url(),
			'icon' => 'fa fa-arrow-circle-left',
			'label' => 'Daftar Module'
		]);
		?>
		<hr/>
		<?php
		if (!empty($msg)) {
			// echo '<pre>'; print_r($msg); die;
			show_alert($msg);
		}
		?>
		<form method="post" class="modal-form" id="add-form" action="<?=current_url()?>" >
			<div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Module</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="nama_module" value="<?=set_value('nama_module', @$nama_module)?>" placeholder="Nama Module" required/> <em>Sesuai nama yang ada di URL</em>
						<input type="hidden" name="nama_module_old" value="<?=set_value('nama_module', @$nama_module)?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Module</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="judul_module" value="<?=set_value('judul_module', @$judul_module)?>" placeholder="Nama Module" required/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Deskripsi</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="deskripsi" value="<?=set_value('deskripsi', @$deskripsi)?>" placeholder="Deskripsi"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Status</label>
					<div class="col-sm-8 form-inline">
						<?php 
						foreach ($module_status as $item) {
							$options[$item['id_module_status']] = $item['nama_status'];
						}
						options(['name' => 'id_module_status'], $options, ['id_module_status', @$id_module_status])?>
					</div>
				</div>
				
				<?php 
				$id = '';
				if (!empty($_GET['id'])) {
					$id = $_GET['id'];
				} elseif (!empty($msg['module_id'])) { // ADD Auto Increment
					$id = $msg['module_id'];
				} ?>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
			</div>
		</form>
	</div>
</div>