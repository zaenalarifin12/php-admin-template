<div class="card">
	<div class="card-header">
		<h5 class="card-title">Data Universitas</h5>
	</div>
	
	<div class="card-body">
		<a href="?action=edit" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Data</a>
		<hr/>
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', 'error', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>No</th>
				<th>Logo</th>
				<th>Nama Universitas</th>
				<th>Nama Kementerian</th>
				<th>Alamat</th>
				<th>Tlp/Fax</th>
				<th>Website</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			require_once('helpers/html.php');
			
			$i = 1;
			foreach ($result as $key => $val) {
				echo '<tr>
						<td>' . $i . '</td>
						<td><div class="list-foto"><img src="'.BASE_URL. $config['kartu_path'] . $val['logo'] . '"/></div></td>
						<td>' . $val['nama_universitas'] . '</td>
						<td>' . $val['nama_kementerian'] . '</td>
						<td>' . $val['alamat'] . '</td>
						<td>' . $val['tlp_fax'] . '</td>
						<td>' . $val['website'] . '</td>
						<td>'. btn_action([
									'edit' => ['url' => '?action=edit&id='. $val['id_universitas']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_universitas']
												, 'delete-title' => 'Hapus data universitas: <strong>'.$val['nama_universitas'].'</strong> ?'
											]
							]) .
						'</td>
					</tr>';
					$i++;
			}
			?>
			</tbody>
			</table>
			</div>
			<?php 
		} ?>
	</div>
</div>