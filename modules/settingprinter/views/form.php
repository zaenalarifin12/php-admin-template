<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php 
			include 'helpers/html.php';
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		?>
		<form method="post" action="" class="form-horizontal">
			<div class="tab-content" id="myTabContent">
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Dot Per Inchi</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" name="dpi" value="<?=set_value('dpi', @$dpi)?>" required="required"/>&nbsp;dpi
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Margin Kiri</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" step="0.1" name="margin_kiri" value="<?=set_value('margin_kiri', @$margin_kiri)?>" required="required"/>&nbsp;cm
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Margin Atas</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" step="0.1" name="margin_atas" value="<?=set_value('margin_atas', @$margin_atas)?>"/>&nbsp;cm
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Margin Kartu Kanan</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" step="0.1" name="margin_kartu_kanan" value="<?=set_value('margin_kartu_kanan', @$margin_kartu_kanan)?>"/>&nbsp;cm
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Margin Kartu Bawah</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" step="0.1" name="margin_kartu_bawah" value="<?=set_value('margin_kartu_bawah', @$margin_kartu_bawah)?>"/>&nbsp;cm
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Margin Kartu Depan Belakang</label>
					<div class="col-sm-5 form-inline">
						<input class="form-control" type="number" step="0.1" name="margin_kartu_depan_belakang" value="<?=set_value('margin_kartu_depan_belakang', @$margin_kartu_depan_belakang)?>"/>&nbsp;cm
						<em>Margin antara kartu depan dan belakang, kartu depan dan belakang dicetak atas bawah</em>
					</div>
					
				</div>
				<div class="form-group row mb-0">
					<div class="col-sm-5">
						<button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
						<input type="hidden" name="id" value="<?=@$_GET['id']?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>