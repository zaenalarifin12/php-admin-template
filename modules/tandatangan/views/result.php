<div class="card">
	<div class="card-header">
		<h5 class="card-title">Data Tanda Tangan</h5>
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
				<th>Stempel</th>
				<th>Tanda Tangan</th>
				<th>Kota</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Tgl. Tandatangan</th>
				<th>Jabatan</th>
				<th>Gunakan</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			require_once('helpers/html.php');
			
			$i = 1;
			foreach ($result as $key => $val) {
				$checked = $val['gunakan'] == 1 ? ' CHECKED="CHECKED"' : '';
				$data_checked =  $val['gunakan'] == 1 ? ' data-checked=1' : ' data-checked=0';
				echo '<tr>
						<td>' . $i . '</td>
						<td><div class="list-foto"><img src="'.BASE_URL. $config['kartu_path'] . $val['file_cap_tandatangan'] . '"/></div></td>
						<td><div class="list-foto"><img src="'.BASE_URL. $config['kartu_path'] . $val['file_tandatangan'] . '"/></div></td>
						<td>' . $val['kota_tandatangan'] . '</td>
						<td>' . $val['nama_tandatangan'] . '</td>
						<td>' . $val['nip_tandatangan'] . '</td>
						<td>' . format_tanggal($val['tgl_tandatangan']) . '</td>
						<td>' . $val['jabatan'] . '</td>
						<td> <input type="radio" data-id="'.$val['id_tandatangan'] .'" name="default"'.$checked.$data_checked.'></td>
						<td>'. btn_action([
									'edit' => ['url' => '?action=edit&id='. $val['id_tandatangan']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_tandatangan']
												, 'delete-title' => 'Hapus data kartu: <strong>'.$val['nama_tandatangan'].'</strong> ?'
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