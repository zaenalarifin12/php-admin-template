<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Role</h5>
	</div>
	
	<div class="card-body">
		<a href="?action=add" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Role</a>
		<hr/>
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			
			/* foreach($module_role as $val) {
				$module_role_list[$val['
			} */
			
			foreach($module as $val) {
				$module_list[$val['id_module']] = $val;
			}
			foreach($module_status as $val) {
				$module_status_list[$val['id_module_status']] = $val['nama_status'];
			}
			// echo '<pre>'; print_r($module_status_list);
			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>No</th>
				<th>Nama Role</th>
				<th>Judul Role</th>
				<th>Default Module</th>
				<th>Keterangan</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($module_role as $key => $val) {
				$module_allowed[$val['id_role']][$val['id_module']] = $val['nama_module'] . ' | ' . $val['judul_module'] . ' (' . $module_status_list[$val['id_module_status']] . ')';
			}
			foreach ($result as $key => $val) {
				echo '<tr>
						<td>' . ($key + 1) . '</td>
						<td>' . $val['nama_role'] . '</td>
						<td>' . $val['judul_role'] . '</td>
						<td>';
						
						if (key_exists($val['id_role'], $module_allowed)) {
							if (!key_exists($val['id_module'], $module_allowed[$val['id_role']])) {
								echo '<p class="mt-0 mb-0">
											<span class="text-danger">Module <strong>' . $module_list[$val['id_module']]['nama_module'] . '</strong> belum di assing ke role ini, silakan <a href="'.BASE_URL.'/module-role" target="_blank">assign</a> terlebih dahulu</span>
									</p>';
							} else {
								echo $module_list[$val['id_module']]['nama_module'] . ' | ' . $module_list[$val['id_module']]['judul_module'] . ' (' . $module_status_list[$module_list[$val['id_module']]['id_module_status']] . ')';
							}
						} else {
							echo '<p class="mt-0 mb-0">
									<span class="text-danger">Tidak ada module yang di assing ke role ini, silakan <a href="'.BASE_URL.'/module-role" target="_blank">assign</a> terlebih dahulu</span>
								</p>';
						}
						
				echo '</td>
						<td>' . $val['keterangan'] . '</td>
						<td>
							<div class="btn-action-group">
							<a href="?module=role&action=edit&id='. $val['id_role'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
							<form method="post" action="'.current_url().'"><button data-action="delete-data" data-delete-title="Hapus Role: <strong>'.$val['judul_role'].'</strong>?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button><input type="hidden" name="id" value="'.$val['id_role'].'"/><input type="hidden" name="delete" value="delete"/></form>
							</div>
						</td>
					</tr>';
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
		
	</div>
</div>