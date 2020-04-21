<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$app_module['judul_module']?></h5>
	</div>
	
	<div class="card-body">
	<form id="form-cetak" method="get" action="" target="_blank">
		<?php 
		require_once('helpers/html.php');
		if (!$result) {
			show_message('Data tidak ditemukan', 'error', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			echo btn_submit([
								'print' => ['url' => '?action=print'
												, 'btn_class' => 'btn-primary disabled'
												, 'icon' => 'fa fa-print'
												, 'text' => '&nbsp;Cetak Yang Dicentang'
												, 'attr' => ['target' => '_blank', 'disabled' => 'disabled']
											]
							]);
			
			echo '<hr/>';
							
			?>
			<input type="hidden" name="action" value="print"/>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="table-result">
			<thead>
			<tr>
				<th><input type="checkbox" class="checkbox check-all" name="check_all"/></th>
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
			
			
			$i = 1;
			foreach ($result as $key => $val) {
				echo '<tr>
						<td><input type="checkbox" class="checkbox" name="id[]" value="'.$val['id_mahasiswa'].'"/></td>
						<td><div class="list-foto"><img src="'.BASE_URL.'/assets/images/foto/' . $val['foto'] . '"/></div></td>
						<td>' . $val['nama'] . '</td>
						<td>' . $val['tempat_lahir'] . ', ' . format_tanggal($val['tgl_lahir']) . '</td>
						<td>' . $val['alamat'] . '</td>
						<td>' . $val['npm'] . '</td>
						<td>' . $val['prodi'] . '</td>
						<td>' . $val['fakultas'] . '</td>
						<td>'. btn_action([
								'print' => ['url' => '?action=print&id[]='. $val['id_mahasiswa']
												, 'btn_class' => 'btn-primary'
												, 'icon' => 'fa fa-print'
												, 'text' => 'Cetak'
												, 'attr' => ['target' => '_blank']
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
		}
		echo btn_submit([
						'print' => ['url' => '?action=print'
										, 'btn_class' => 'btn-primary disabled'
										, 'icon' => 'fa fa-print'
										, 'text' => '&nbsp;Cetak Yang Dicentang'
										, 'attr' => ['target' => '_blank', 'disabled' => 'disabled']
									]
					]);

		?>
	</form>
	</div>
</div>