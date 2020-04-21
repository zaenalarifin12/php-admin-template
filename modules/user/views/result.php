<div class="card">
	<div class="card-body">
	<div class="table-responsive">
	<a href="?action=add" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Data</a>
		<hr/>
		<?php

		if (!empty($msg)) {
			show_message($msg);
		} else {
			?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>No</th>
				<th>Avatar</th>
				<th>Username</th>
				<th>Email</th>
				<th>Nama</th>
				<th>Role</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
				<?php
				require_once('helpers/html.php');
				$no = 1;
				global $list_action;
				foreach ($users as $key => $val) {
					if ($val['avatar']) {
						if (file_exists($config['user_images_path'] . $val['avatar'])) {
							$avatar = BASE_URL . $config['user_images_path'] . $val['avatar'];
						} else {
							$avatar = BASE_URL . $config['user_images_path'] . $val['avatar'];
						}
					} else {
						$avatar = BASE_URL . $config['user_images_path'] . 'default.png';
					}
					$btn['edit'] = ['url' => module_url() . '?action=edit&id='. $val['id_user']];
					if ($list_action['delete_data'] == 'own' || $list_action['delete_data'] == 'all') {
						$btn['delete'] = ['url' => module_url()
														, 'id' =>  $val['id_user']
														, 'delete-title' => 'Hapus data user: <strong>'.$val['nama'].'</strong> ?'
													]
									;
					}
					echo '<tr>
							<td>' . $no . '</td>
							<td><div class="list-foto"><img src="' . $avatar . '"/></div></td>
							<td>' . $val['username'] . '</td>
							<td>' . $val['email'] . '</td>
							<td>' . $val['nama'] . '</td>
							<td>' . $val['judul_role'] . '</td>
							<td>'. btn_action($btn) .
							'</td>
						</tr>';
					$no++;
				}
				?>
			</tbody>
		</table>
		<?php }
		
		?>
		</div>
	</div>
</div>