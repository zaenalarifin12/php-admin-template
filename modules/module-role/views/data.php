<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th>Nama Module</th>
				<th>Judul Module</th>
				<th>Role</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			// echo $module; die;
			foreach ($module as $key => $val) 
			{
				
				$list = '';
				if (key_exists($val['id_module'], $module_role)) {
					$roles = $module_role[$val['id_module']];
					foreach ($roles as $role_id) 
					{
						$list .= '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">' . $role[$role_id]['judul_role'] . '<a data-action="remove-role" data-pair-id="'.$val['id_module'].'" data-role-id="'.$role_id.'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
					}
				}
				echo '<tr>
						<td>' . $val['id_module'] . '</td>
						<td>' . $val['nama_module'] . '</td>
						<td>' . $val['judul_module'] . '</td>
						<td>' . $list . '</td>
						<td>
							<div class="btn-action-group">
								<a data-pair-id="'.$val['id_module'].'" href="' . module_url() . '?action=edit&id=' . $val['id_module'] .'" class="btn btn-success btn-xs mr-1 role-edit"><i class="fa fa-edit pr-1"></i> Edit</a>
								<a href="' . module_url() . '?action=detail&id=' . $val['id_module'] .'" class="btn btn-primary btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Detail</a>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
		
	</div>
</div>