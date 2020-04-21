<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php
		include 'helpers/html.php';
			echo btn_label(['class' => 'btn btn-success btn-xs',
				'url' => module_url() . 'edit',
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
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			?>
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th>Nama Module</th>
				<th>Judul Module</th>
				<th>Deskripsi</th>
				<th>Status</th>
				<th>Aktif/Nonaktif</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			foreach ($result as $key => $val) {
				if ($val['module_status_id'] == 1) {
					$module_status_id = 0;
					$btn_class = 'btn-danger';
					$btn_text = 'Non Aktifkan';
				} elseif ($val['module_status_id'] != 1) {
					$module_status_id = 1;
					$btn_class = 'btn-success';
					$btn_text = 'Aktifkan';
				}
				echo '<tr>
						<td>' . $val['module_id'] . '</td>
						<td>' . $val['module_nama'] . '</td>
						<td>' . $val['module_judul'] . '</td>
						<td>' . $val['deskripsi'] . '</td>
						<td>' . $val['nama_status'] . '</td>
						<td>
							<form method="post">
								<input type="hidden" name="change_module_status" value="1">
								<input type="hidden" name="module_id" value="'.$val['module_id'].'">
								<input type="hidden" name="module_status_id" value="'. $module_status_id .'">
								<button type="submit" class="btn btn-xs ' . $btn_class . ' ">'. $btn_text .'</button>
							</form>
						</td>
						<td>
							<div class="form-inline">
							<a href="' . module_url() . 'edit/?id=' . $val['module_id'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit pr-1"></i> Edit</a>
							<form method="post" action="'.current_url().'"><button data-action="delete-data" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times mr-1"></i> Delete</button><input type="hidden" name="id" value="'.$val['module_id'].'"/><input type="hidden" name="delete" value="delete"/></form>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			<?php 
		} ?>
		
	</div>
</div>