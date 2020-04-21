<html !DOCTYPE="HTML">
<head>
<title>
<?php echo $app_module['judul_module'] . ' | ' . $setting_web['judul_web']?>
</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=$config['base_url'] . 'assets/images/favicon.png'?>" />
<meta name="description" content="<?=$app_module['deskripsi']?>">
<link rel="shortcut icon" href="<?=$config['images_url'] . 'favicon.png"'?> />
<?php
require_once('helpers/html.php');
require_once('includes/functions.php');
$px = 0.393700787; 
$dim = get_dimensi_kartu($layout['panjang'], $layout['lebar'], $printer['dpi']);
// echo '<pre>'; print_r($printer['dpi']); die;
$panjang = $dim['w'];
$lebar = $dim['h']; 
$margin_kiri = $printer['margin_kiri'] * $printer['dpi'] * $px;
$margin_atas = $printer['margin_atas'] * $printer['dpi'] * $px;
$margin_kartu_kanan = $printer['margin_kartu_kanan'] * $printer['dpi'] * $px;
$margin_kartu_bawah = $printer['margin_kartu_bawah'] * $printer['dpi'] * $px;
$margin_kartu_depan_belakang = $printer['margin_kartu_depan_belakang'] * $printer['dpi'] * $px;
?>
<style>
body, html {
	margin: 0;
	padding: 0;
	font-family: arial;
	font-size: <?=(9.5 * $printer['dpi']/100)?>px;
	font-weight: bold;
}
.cetak-container {
	padding-top: <?=$margin_atas?>px;
	padding-left: <?=$margin_kiri?>px;
	max-width:<?=$margin_kiri + (2 * $panjang) + $margin_kartu_kanan + 100?>px;
}
.kartu-container {
	margin:0;
	margin-right: <?=$margin_kartu_kanan?>px;
	margin-bottom: <?=$margin_kartu_bawah?>px;
	/* border:1px solid;  */
	float:left;
	width:<?=$panjang?>px;
}

.kartu-foto {
	width:<?=80 * $printer['dpi']/100?>px;
	height:auto;
	margin-left: <?=20 * $printer['dpi']/100?>px;
    margin-top: <?=62 * $printer['dpi']/100?>px;
	float: left;
}

.kartu-foto img{
	width: 100%;
}
.kartu-detail {
	margin-top: <?=62 * $printer['dpi']/100?>px;
	margin-left: <?=110 * $printer['dpi']/100?>px;
}
.kartu-detail label{
	width:<?=60 * $printer['dpi']/100?>px;
	display:inline-block;
}

.kartu-content-container {
	position: relative;
	border:1px solid #FFFFFF;
	margin:0;
	width:<?=$panjang ?>px;
	height:<?= $lebar ?>px;
	background:url('<?= $config['kartu_path'] . $layout['background_depan']?>'); 
	background-repeat: no-repeat; 
	background-size: <?=$panjang?>px <?=$lebar?>px;
}

.kartu-belakang {
	margin-top: <?=$margin_kartu_depan_belakang?>px;
	background:url('<?=$config['kartu_path'] . $layout['background_belakang']?>'); 
	background-repeat: no-repeat; 
	background-size: <?=$panjang?>px <?=$lebar?>px;
}
.kartu-tandatangan {
	position: absolute;
	bottom: <?=10 * $printer['dpi']/100?>px;
	right: <?=10 * $printer['dpi']/100?>px;
	text-align: center;
}
.kartu-tandatangan p{
	margin:0;
	padding:0;
	
}
.kartu-tandatangan .jabatan {
	margin-bottom: <?=20 * $printer['dpi']/100?>px;
}
.scan-tandatangan {
	position: absolute;
    width: <?=50 * $printer['dpi']/100?>px;
    top: 10px;
    left: <?=40 * $printer['dpi']/100?>px;
}

.cap-tandatangan {
	position: absolute;
    width: <?=70 * $printer['dpi']/100?>px;
    top: <?=-5 * $printer['dpi']/100?>px;
    left: <?=-30 * $printer['dpi']/100?>px;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

.scan-barcode {
	position: absolute;
    width: <?=30 * $printer['dpi']/100?>px;
    bottom: <?= 10 * $printer['dpi']/100?>px;
    left: <?=20 * $printer['dpi']/100?>px;
}
.tgl-berlaku {
	position: absolute;
    bottom: <?= 10 * $printer['dpi']/100?>px;
    left: <?=55 * $printer['dpi']/100?>px;
}
</style>
</head>
<body>

<div class="cetak-container" >
<?php
$qrcode['content'] = '<div class="qrcode-container" style="position:absolute;top:'.$qrcode['posisi_top'].'px;left:'.$qrcode['posisi_left'].'px;padding:' . $qrcode['padding'] . ';background:#FFFFFF">' . generateQRCode($qrcode['version'], $qrcode['ecc'], $qrcode['global_text'], $qrcode['size_module']) . '</div>';
// echo '<pre>'; print_r($nama); die;
foreach ($id as $val) { ?>
	<div class="kartu-container">
		<div class="kartu-content-container">
			<div class="kartu-foto">
				<img src="<?=$config['foto_path'] . $nama[$val]['foto']?>"/>
			</div>
			<div class="kartu-detail">
				<div>
					<label>NAMA</label>:<?=$nama[$val]['nama']?>
				</div>
				<div>
					<label>TTL</label>:<?=$nama[$val]['tempat_lahir']. ', ' . format_tanggal($nama[$val]['tgl_lahir'])?>
				</div>
				<div>
					<label>NPM</label>:<?=$nama[$val]['npm']?>
				</div>
				<div>
					<label>PRODI</label>:<?=$nama[$val]['prodi']?>
				</div>
				<div>
					<label>FAKULTAS</label>:<?=$nama[$val]['fakultas']?>
				</div>
				<div>
					<label>ALAMAT</label>:<?=$nama[$val]['alamat']?>
				</div>
			</div>
			<div class="kartu-tandatangan">
				<p><?=$ttd['kota_tandatangan'] . ', ' . format_tanggal($ttd['tgl_tandatangan'])?></p>
				<p class="jabatan"><?=$ttd['jabatan']?>,</p>
				<img class="scan-tandatangan" src="<?=$config['kartu_path'] . $ttd['file_tandatangan']?>"/>
				<img class="cap-tandatangan" src="<?=$config['kartu_path'] . $ttd['file_cap_tandatangan']?>"/>
				<p><?=$ttd['nama_tandatangan']?></p>
				<p>NIP. <?=$ttd['nip_tandatangan']?></p>
			</div>
			<div>
				<?php
					if ($qrcode['posisi_kartu'] == 'background_depan') {
						echo $qrcode['content'];
					}
				?>
			</div>
			<div class="tgl-berlaku">
				Berlaku s.d <?=format_tanggal(date('Y-m-d', strtotime(date('Y-m-d', strtotime($ttd['tgl_tandatangan']. '+4 years')))))?>
			</div>
		</div>
		
		<div class="kartu-content-container kartu-belakang">
			<?php
				if ($qrcode['posisi_kartu'] == 'background_belakang') {
					echo $qrcode['content'];
				}
			
			?>
		
		</div>
	</div>
	<?php
}
?>
	<div class="clearfix"></div>
</div>
</body>
</html>