<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			include 'helpers/html.php';
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => module_url() . '?action=add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah ' . $app_module['judul_module']
			]);
			
			echo btn_label(['class' => 'btn btn-light btn-xs',
				'url' => module_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar ' . $app_module['judul_module']
			]);
		?>
		<hr/>
		<?php
		if (!empty($msg)) {
			show_message($msg);
		}
		?>
		<form method="post" action="" class="form-horizontal">
			<div class="tab-content" id="myTabContent">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Username</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="username" value="<?=set_value('username', @$username)?>" placeholder="Username" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Nama</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="nama" value="<?=set_value('nama', @$nama)?>" placeholder="Nama" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Email</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="text" name="email" value="<?=set_value('email', @$email)?>" placeholder="Email" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8 form-inline">
						<?php
						foreach ($role as $key => $val) {
							$options[$val['id_role']] = $val['judul_role'];
						}
						echo options(['name' => 'id_role'], $options, set_value('id_role', @$id_role));
						?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="password" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Ulangi Password Baru</label>
					<div class="col-sm-8 form-inline">
						<input class="form-control" type="password" name="ulangi_password" required="required"/>
					</div>
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-8">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>