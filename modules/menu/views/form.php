<?php
require_once('includes/functions.php');
require_once('helpers/html.php');?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">Data Menu</h5>
	</div>
	
	<div class="card-body">
		<a href="?module=gedung&action=add" class="btn btn-success btn-xs" id="add-menu"><i class="fa fa-plus pr-1"></i> Tambah Menu</a>
		<hr/>
		<form style="display:none" method="post" class="modal-form" id="add-form" action="<?=current_url()?>" >
			<div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Menu</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="nama_menu" value="" placeholder="Nama Menu" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">URL</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="url" value="" placeholder="URL" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Aktif</label>
					<div class="col-sm-8">
						<div class="mt-2">
						<input id="menu_aktif" type="checkbox" name="aktif" class="switch is-info is-medium" checked="checked">
						 <label for="menu_aktif"></label>
						</div>
						<small class="form-text text-muted"><em>Jika tidak aktif, semua children tidak akan dimunculkan</em></small>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Module</label>
					<div class="col-sm-8 form-inline">
						<?php
						
						$options[0] = 'Tidak ada module';
						foreach ($list_module as $key => $val) {
							$options[$val['id_module']] = $val['nama_module'] . ' | ' . $val['judul_module'] . ' (' . $val['nama_status']  . ')';
						}
						options(['name' => 'id_module', 'id' => 'id-module'], $options);
						
						echo '<small class="form-text text-muted"><em>Untuk highlight menu dan parent</em></small>';
						?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Use icon</label>
					<div class="col-sm-8 form-inline">
						<input type="hidden" name="icon_class" value="far fa-circle"/>
						<?php 
							$options = array(1 => 'Ya', 0 => 'Tidak');
							options(['name' => 'use_icon'], $options);
						?>
						<a href="javascript:void(0)" class="icon-preview" data-action="faPicker"><i class="far fa-circle"></i></a>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Role</label>
					<div class="col-sm-8 form-inline">
						Untuk memunculkan menu, assign role ke menu
						<?php
				
						/* foreach ($role as $val) {
							$list_role[] = ['name' => 'id_role[]'
											, 'id' => 'id_role_' . $val['id_role']
											, 'label' => $val['judul_role']
											, 'parent_class' => 'mr-2'
										];
							
						}
						checkbox($list_role); */
			
						?>
					</div>
				</div>
				<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
				
			</div>
		</form>
		<?php

		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		
		<div class="dd" id="list-menu">
			<?=$data['list_menu']?>
		</div>
		<form method="POST" action="?module=menu" id="save-menu">
			<textarea class="hidden" id="menu-data" name="data" style="display:none"></textarea>
			<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
		</form>
	</div>
</div>