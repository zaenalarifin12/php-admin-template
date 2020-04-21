/**
* Written by: Agus Prawoto Hadi
* Year		: 2020
* Website	: jagowebdev.com
*/

$(document).ready(function() 
{
	$('#list-menu').wdiMenuEditor({
		expandBtnHTML   : '<button data-action="expand" class="fa fa-plus" type="button">Expand</button>',
        collapseBtnHTML : '<button data-action="collapse" class="fa fa-minus" type="button">Collapse</button>',
		editBtnCallback : function($list) 
		{
			var $button = '';
			var	$bootbox = showForm('edit');
			
			var $button = $bootbox.find('button').prop('disabled', true);
			var $loader = $bootbox.find('.loader');

			$.getJSON(base_url + '?module=menu&action=menu_detail&ajax=true&id=' + $list.data('id'), function(result) 
			{
				$loader.remove();
				$button.prop('disabled', false);
				
				var $form = $('#add-form').clone().show();
				$form.find('[name="nama_menu"]').val(result.nama_menu);
				$form.find('[name="url"]').val(result.url);
				$form.find('[name="id"]').val(result.id_menu);
				
				var id = 'id_' + Math.random();
				$checkbox = $form.find('[type="checkbox"]').attr('id', id);
				$checkbox.siblings('label').attr('for', id);
		
				$aktif = $form.find('[name="aktif"]');
				if (result.aktif == 1) {
					$aktif.attr('checked', 'checked');
				} else {
					$aktif.removeAttr('checked');
				}
				
				// Module
				if (result.id_module != null) {
					$form.find('[name="id_module"]').val(result.id_module);
				}
				
				$use_icon = $form.find('[name="use_icon"]');
				$icon = $form.find('[name="icon_class"]');
				// console.log(result);
				if (result.class != null && $.trim(result.class) != '' && result.class != 'null') {
					$use_icon.val(1);
					$icon.val(result.class);
					$form.find('.icon-preview').find('i').removeAttr('class').addClass(result.class);
				} else {
					$use_icon.val(0);
					$icon.val('');
					$form.find('.icon-preview').hide();
				}
				
				$bootbox.find('.modal-body').empty().append($form);
			})
		},
		beforeRemove: function(item, plugin) {
			var $bootbox = bootbox.confirm({
				message: "Yakin akan menghapus menu?<br/>Semua submenu (jika ada) akan ikut terhapus",
				buttons: {
					confirm: {
						label: 'Yes',
						className: 'btn-success submit'
					},
					cancel: {
						label: 'No',
						className: 'btn-danger'
					}
				},
				callback: function(result) {
					if(result) {
						$button = $bootbox.find('button').prop('disabled', true);
						$button_submit = $bootbox.find('button.submit');
						$button_submit.prepend('<i class="fas fa-circle-notch fa-spin mr-2 fa-lg"></i>');
						$.ajax({
							type: 'POST',
							url: base_url + '?module=menu&action=delete',
							data: 'id=' + item.attr('data-id'),
							success: function(msg) {
								msg = $.parseJSON(msg);
								if (msg.status == 'ok') {
									Swal.fire({
										text: msg.message,
										title: 'Sukses !!!',
										type: 'success',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
									plugin.deleteList(item);
								} else {
									Swal.fire({
										title: 'Error !!!',
										text: msg.message,
										type: 'error',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								}
							},
							error: function() {
								
							}
						})
					}
				}
				
			});
		}
	});
	
	$('#save-menu').submit(function(e) 
	{
		list_data = $('#list-menu').wdiMenuEditor('serialize');
		data = JSON.stringify(list_data);
		$('#menu-data').empty().text(data);
	})
	
	$(document).on('change', 'select[name="use_icon"]', function(){
		$this = $(this);
		if (this.value == 1) 
		{
			$icon_preview = $this.next().show();
			$this.next().show();
			var calass_name = $icon_preview.find('i').attr('class');
			$this.parent().find('[name="icon_class"]').val(calass_name);
		} else {
			$this.next().hide();
		}
	});
	
	$('#add-menu').click(function(e) 
	{
		e.preventDefault();
		var $add_form = $('#form-edit').clone();
		var id = 'id_' + Math.random();
		$checkbox = $add_form.find('[type="checkbox"]').attr('id', id);
		$checkbox.siblings('label').attr('for', id);
		$bootbox = showForm('add');
	});
	
	function showForm(type='add') 
	{
		var $button = '';
		var $bootbox = '';
		var $button_submit = '';
			
		var $form = $('#add-form').clone().show();
		var id = 'id_' + Math.random();
		$checkbox = $form.find('[type="checkbox"]').attr('id', id);
		$checkbox.siblings('label').attr('for', id);
// console.log($form[0].outerHTML);
		if (type == 'edit') {
			var msg = '<div class="loader-ring loader"></div>';
		} else {
			var msg = '<div class="form-container">' +  $form[0].outerHTML + '</div>';
		}
		
		$bootbox =  bootbox.dialog({
			title: type == 'edit' ? 'Edit Menu' : 'Tambah Menu',
			message: msg,
			buttons: {
				cancel: {
					label: 'Cancel'
				},
				success: {
					label: 'Submit',
					className: 'btn-success submit',
					callback: function() 
					{
						$bootbox.find('.alert').remove();
						$button_submit.prepend('<i class="fas fa-circle-notch fa-spin mr-2 fa-lg"></i>');
						$button.prop('disabled', true);
						$form_filled = $bootbox.find('form');
						$.ajax({
							type: 'POST',
							url: base_url + '?module=menu&action=edit',
							data: $form_filled.serialize(),
							dataType: 'text',
							success: function (data) {
								// console.log(data);
								data = $.parseJSON(data);
								
								if (data.status == 'ok') 
								{
									var nama_menu = $form_filled.find('input[name="nama_menu"]').val();
									var id = $form_filled.find('input[name="id"]').val();
									var use_icon = $form_filled.find('select[name="use_icon"]').val();
									var icon_class = $form_filled.find('input[name="icon_class"]').val();
									// edit
									if (id) {
										$menu = $('#list-menu').find('[data-id="'+id+'"]');
										$menu.find('.menu-title:eq(0)').text(nama_menu);
									} 
									// add
									else {
										$menu_container = $('#list-menu').children();
										$menu = $menu_container.children(':eq(0)').clone();
										$menu.find('ol, ul').remove();
										$menu.find('[data-action="collapse"]').remove();
										$menu.find('[data-action="expand"]').remove();
										$menu.attr('data-id', data.id_menu);
										$menu.find('.menu-title').text(nama_menu);
									}
									
									$handler = $menu.find('.dd-handle:eq(0)');
									$handler.find('i').remove();
									
									if (use_icon == 1) {
										$handler.prepend('<i class="'+icon_class+'"></i>');
									}
									
									if (!id) {
										$menu_container.prepend($menu);
									}
										
									$bootbox.modal('hide');
									// bootbox.alert(data.message);
									Swal.fire({
										title: 'Sukses !!!',
										text: data.message,
										type: 'success',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
								} else {
									$button_submit.find('i').remove();
									$button.prop('disabled', false);
									if (data.error_query != undefined) {
										Swal.fire({
											title: 'Error !!!',
											html: data.message,
											type: 'error',
											showCloseButton: true,
											confirmButtonText: 'OK'
										})
									} else {
										$bootbox.find('.modal-body').prepend('<div class="alert alert-dismissible alert-danger" role="alert">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
									}
								}
							},
							error: function (xhr) {
								console.log(xhr.responseText);
							}
						})
						return false;
					}
				}
			}
		});
		
		$button = $bootbox.find('button').prop('disabled', false);
		$button_submit = $bootbox.find('button.submit');
		
		if (type == 'edit') {
			$button.prop('disabled', true);
		}
		
		return $bootbox;
	}
	
	$(document).on('click', '.icon-preview', function() {

		$this = $(this);
		fapicker({
			iconUrl: base_url + 'assets/vendors/font-awesome/metadata/icons.yml',
			onSelect: function (elm) {
				
				var icon_class = $(elm).data('icon');
				$this.find('i').removeAttr('class').addClass(icon_class);
				$this.parent().find('[name="icon_class"]').val(icon_class);
			}
		});
	});
});