<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$app_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
		<a href="?action=add" class="btn btn-success btn-xs"><i class="fa fa-plus pr-1"></i> Tambah Data</a>
		<hr/>
		<?php 
		include 'helpers/html.php';
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
				<th>DPI</th>
				<th>Margin Kiri</th>
				<th>Margin Atas</th>
				<th>Margin Kartu Kanan</th>
				<th>Margin Kartu Bawah</th>
				<th>Margin Kartu Depan Belakang</th>
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
				echo '<tr>
						<td>' . $i . '</td>
						<td>' . $val['dpi'] . '</td>
						<td>' . $val['margin_kiri'] . '</td>
						<td>' . $val['margin_atas'] . '</td>
						<td>' . $val['margin_kartu_kanan'] . '</td>
						<td>' . $val['margin_kartu_bawah'] . '</td>
						<td>' . $val['margin_kartu_depan_belakang'] . '</td>
						<td> <input type="radio" name="gunakan" data-id="'.$val['id_setting_printer'].'"'.$checked.'></td>
						<td>'. btn_action([
									'edit' => ['class' => 'mb-2', 'url' => '?action=edit&id='. $val['id_setting_printer']]
									, 'delete' => ['class' => 'mb-2', 'url' => ''
												, 'id' =>  $val['id_setting_printer']
												, 'delete-title' => 'Hapus data ?'
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