<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$app_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<a href="?action=add" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Data</a>
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
				<th>Foto</th>
				<th>Nama</th>
				<th>TTL</th>
				<th>ALAMAT</th>
				<th>NPM</th>
				<th>PRODI</th>
				<th>FAKULTAS</th>
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
						<td><div class="list-foto"><img src="'.BASE_URL.'/assets/images/foto/' . $val['foto'] . '"/></div></td>
						<td>' . $val['nama'] . '</td>
						<td>' . $val['tempat_lahir'] . ', ' . format_tanggal($val['tgl_lahir']) . '</td>
						<td>' . $val['alamat'] . '</td>
						<td>' . $val['npm'] . '</td>
						<td>' . $val['prodi'] . '</td>
						<td>' . $val['fakultas'] . '</td>
						<td>'. btn_action([
									'edit' => ['url' => '?action=edit&id='. $val['id_mahasiswa']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_mahasiswa']
												, 'delete-title' => 'Hapus data mahasiswa: <strong>'.$val['nama'].'</strong> ?'
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