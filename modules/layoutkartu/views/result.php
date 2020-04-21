<div class="card">
	<div class="card-header">
		<h5 class="card-title">Data Universitas</h5>
	</div>
	
	<div class="card-body">
		<a href="?action=add" class="btn btn-success btn-xs mb-2"><i class="fa fa-plus pr-1"></i> Tambah Data</a>
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
				<th>Background Depan</th>
				<th>Background Belakang</th>
				<th>Nama Layout</th>
				<th>Dimensi P x L (cm)</th>
				<th>Berlaku</th>
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
						<td><div class="list-foto"><img src="'.BASE_URL . $config['kartu_path'] . $val['background_depan'] . '"/></div></td>
						<td><div class="list-foto"><img src="'.BASE_URL. $config['kartu_path'] . $val['background_belakang'] . '"/></div></td>
						<td>' . $val['nama_layout'] . '</td>
						<td>' . $val['panjang'] . ' x ' . $val['lebar'] . '</td>
						<td>' . $val['berlaku'] . ' Tahun sejak terbit</td>
						<td> <input type="radio" data-id="'.$val['id_layout_kartu'] .'" name="default"'.$checked.$data_checked.'></td>
						<td>'. btn_action([
									'edit' => ['url' => '?action=edit&id='. $val['id_layout_kartu']]
								, 'delete' => ['url' => ''
												, 'id' =>  $val['id_layout_kartu']
												, 'delete-title' => 'Hapus data kartu: <strong>'.$val['nama_layout'].'</strong> ?'
											]
							]) .
						'</td>
					</tr>';
					$i++;
			}
			?>
			</tbody>
			</table>
			<?php 
		} ?>
		</div>
	</div>
</div>