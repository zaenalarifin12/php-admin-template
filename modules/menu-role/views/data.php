<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php 
		if (!$menu) {
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
				<th>Menu</th>
				<th>URL</th>
				<th>Role</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			// echo $module; die;
			foreach ($menu as $key => $val) 
			{
				
				$list = '';
				if (key_exists($val['id_menu'], $menu_role)) {
					$roles = $menu_role[$val['id_menu']];
					foreach ($roles as $id_role) 
					{
						$list .= '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">' . $role[$id_role]['judul_role'] . '<a data-action="remove-role" data-id-menu="'.$val['id_menu'].'" data-role-id="'.$id_role.'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
					}
				}
				echo '<tr>
						<td>' . $val['id_menu'] . '</td>
						<td>' . $val['nama_menu'] . '</td>
						<td>' . $val['url'] . '</td>
						<td>' . $list . '</td>
						<td>
							<div class="btn-action-group">
							<a data-id-menu="'.$val['id_menu'].'" href="' . module_url() . '/edit?id=' . $val['id_menu'] .'" class="btn btn-success btn-xs mr-1 role-edit"><i class="fa fa-edit"></i>&nbsp;Edit</a>
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