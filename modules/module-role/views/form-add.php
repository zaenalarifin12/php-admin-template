<?php
// require_once('includes/functions.php');
require_once('helpers/html.php');?>

<div class="card">
	<div class="card-header">
		<h5 class="card-title"><?=$title?></h5>
	</div>
	
	<div class="card-body">
		<?php
		if (!empty($msg)) {
			show_message($msg['content'], $msg['status']);
		}
		
		?>
		<form method="post" class="modal-form" id="add-form" action="<?=current_url()?>" >
			<div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Module</label>
					<div class="col-sm-8 form-inline">
						<?=$module['judul_module']?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label">Role</label>
					<div class="col-sm-8">
						
						<?php 
						foreach ($role_detail as $val) {
							$role_detail_options[$val['nama_role_detail']] = $val['nama_role_detail'] . ' | ' . $val['judul_role_detail'];
						}
						
						$module_role_check = [];
						foreach ($module_role as $val) {
							$module_role_check[$val['id_role']] = $val;
						}
						
						echo '<div id="check-all-wrapper">';
						foreach ($role as $role_val) 
						{
							$checkbox = [['class' => 'toggle-role', 'id' => $role_val['id_role'], 'name' => 'role_' . $role_val['id_role'], 'label' => $role_val['judul_role']]];
							
							$checked = [];
							if (isset($_POST['role_' . $role_val['id_role']])) {
								$checked = ['role_' . $role_val['id_role']];
							} else {
								if (key_exists($role_val['id_role'], $module_role_check)) {
									$checked[] = 'role_' . $role_val['id_role'];
								}
							}
							// echo '<pre>';print_r($checked);
							checkbox($checkbox, $checked);
							$display = !$checked ? ' style="display:none"' : '';

							$action = ['read_data' => 'Read', 'create_data' => 'Create', 'update_data' => 'Update', 'delete_data' => 'Delete'];
							
							echo '<div class="ml-4 role-child" ' . $display . '>';
										foreach ($action as $key => $val_action) 
										{
											$selected = '';
											if (isset($_POST['role_' . $role_val['id_role']])) {
												$selected = $_POST['akses_' . $key . '_' . $role_val['id_role']];
											} else {
												if (key_exists($role_val['id_role'], $module_role_check)) {
													$selected = $module_role_check[$role_val['id_role']][$key];
												}
											}
										
											if ($key == 'create_data') {
												$options = options(['name' => 'akses_' . $key . '_' . $role_val['id_role']], ['yes' => 'yes | YA', 'no' => 'no | TIDAK'], $selected, false);
											} else {
												$options = options(['name' => 'akses_' . $key . '_' . $role_val['id_role']], $role_detail_options, $selected, false);
											}
											echo '
											<div class="form-group row form-inline">
											<div class="col-sm-2">'.$val_action.'</div>
											<div class="col-sm-8 form-inline">' . $options . '</div>
											</div>';
										}
							echo '
								</div>';
						}
							
						
						
						
						echo '</div>';
						?>
						
					</div>
				</div>
				
				<?php 
				$id = '';
				if (!empty($msg['id_module'])) {
					$id = $msg['id_module']; // Setelah submit add
				} elseif (!empty($_GET['id'])) {
					$id = $_GET['id'];
				} ?>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<button type="submit" name="submit" value="submit" class="btn btn-primary mt-2">Save</button>
			</div>
		</form>
	</div>
</div>