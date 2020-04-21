<?php
require_once('includes/functions.php');
require_once('helpers/html.php');

?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<a href="?module=role&action=edit" class="btn btn-success btn-xs" id="add-menu"><i class="fa fa-plus pr-1"></i> Tambah Role</a>
		<hr/>
		<?php
		if (!empty($msg)) {
			show_alert($msg);
		}
		
		$module_status_list = [];
		if (!empty($module_status)) {
			foreach($module_status as $val) {
				$module_status_list[$val['id_module_status']] = $val['nama_status'];
			}
		}
		
		$module_allowed = [];
		if (!empty($module_role)) {
			foreach ($module_role as $key => $val) {
				$module_allowed[$val['id_role']][$val['id_module']] = $val['nama_module'] . ' | ' . $val['judul_module'] . ' (' . $module_status_list[$val['id_module_status']] . ')';
			}
		}
		
		$id = '';
		if (!empty($msg['role_id'])) {
			$id = $msg['role_id'];
		} elseif (!empty($_GET['id'])) {
			$id = $_GET['id'];
		}
		
		// echo '<pre>'; print_r($module_allowed); die;
		?>
		<form method="post" class="modal-form" id="add-form" action="<?=current_url()?>" >
			<div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="nama_role" value="<?=set_value('nama_role', @$role['nama_role'])?>" placeholder="Nama Role" required="required"/>
						<input type="hidden" name="role_nama_old" value="<?=set_value('role_nama_old', @$role['nama_role'])?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Judul Role</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="judul_role" value="<?=set_value('judul_role', @$role['judul_role'])?>" placeholder="Judul Role" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Keterangan</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="keterangan" value="<?=set_value('keterangan', @$role['keterangan'])?>" placeholder="Keterangan"/>
					</div>
				</div>
				<?php
				if ($id) { ?>
					<div class="form-group row">
						<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Halaman Default</label>
						<div class="col-sm-8">
							<?php
							if (key_exists($role['id_role'], $module_allowed)) {
								options(['name=id_module'], $module_allowed[$role['id_role']], $role['id_module']);
							} else {
								echo '<span class="text-danger">Tidak ada module yang di assing ke role ini, silakan <a href="'.BASE_URL.'/module-role" target="_blank">assign</a> terlebih dahulu</span>';
							}
							?>
							<p class="mt-0"><em>Halaman awal sesaat setelah user login</p>
						</div>
					</div>
				<?php }?>
				<div class="form-group row">
					<input type="hidden" name="id" value="<?=$id?>"/>
					<div class="col-sm-8 offset-sm-2">
						<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>