jQuery(document).ready(function () {
	$('body').delegate('#check-all', 'click', function() {
		var prop = $(this).prop('checked');
		$('#check-all-wrapper').find('input[type="checkbox"]').prop('checked', prop);
	});
	
	$('body').delegate('a[data-action="remove-role"]', 'click', function() {
		$this = $(this);
		// Module - User id
		id_menu = $this.attr('data-id-menu');
		id_role = $this.attr('data-role-id');
		$.ajax({
			type: 'POST',
			url: current_url + '?action=delete-role',
			data: 'id_menu='+ id_menu +'&id_role=' + id_role,
			dataType: 'text',
			success: function (data) {
				// console.log(data);
				data = $.parseJSON(data);
				if (data.status == 'ok') 
				{
					$this.parent().remove();
				} else {
					Swal.fire({
						title: 'Error !!!',
						html: data.message,
						type: 'error',
						showCloseButton: true,
						confirmButtonText: 'OK'
					})
				}
			},
			error: function (xhr) {
				console.log(xhr.responseText);
			}
		})
	});
	
	$('.role-edit').click(function(e) {
		
		e.preventDefault();
		$this = $(this);
		$td = $this.parent().prev();
		
		msg = '<div class="loader-ring loader"></div>';
		$bootbox =  bootbox.dialog({
			title: 'Edit Role',
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
						id_menu = $this.attr('data-id-menu');

						$checkbox_wrapper = $('#check-all-wrapper');
						$.ajax({
							type: 'POST',
							url: current_url + '/edit',
							data: $checkbox_wrapper.serialize() + '&id_menu=' + id_menu,
							dataType: 'text',
							success: function (data) {
								// console.log(data); 
								// return false;
								data = $.parseJSON(data);
								// console.log(data); 
								data_parent = $.parseJSON(data.data_parent);
								// console.log(data_parent); 
								// return false;
								if (data.status == 'ok') 
								{
									new_badge = '';
									label = '';
									id_role = '';
									
									// Ambil label role yang tercentang
									$checkbox_wrapper.find('input:checked').each(function(i, elm) {
										$elm = $(elm);
										
										id_role = $elm.attr('id');
										label = $elm.next().text();
										
										new_badge += '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">'+label+'<a data-action="remove-role" data-id-menu="'+id_menu+'" data-role-id="'+id_role+'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
									});
									$td.empty().append(new_badge);
									
									// Parents
									if (data_parent.length > 0) {
										// new_badge = '';
										$.each(data_parent, function(i, v) {
											$td_other = $('[data-id-menu="'+v['id_menu']+'"]').parent().prev();
											new_badge = '<span class="badge badge-secondary badge-role px-3 py-2 mr-1 mb-1 pr-4">'+label+'<a data-action="remove-role" data-id-menu="'+v['id_menu']+'" data-role-id="'+v['id_role']+'" href="javascript:void(0)" class="text-danger"><i class="fas fa-times"></i></a></span>';
											$td_other.append(new_badge);
										});
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
									Swal.fire({
										title: 'Error !!!',
										html: data.message,
										type: 'error',
										showCloseButton: true,
										confirmButtonText: 'OK'
									})
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
		var $button = $bootbox.find('button').prop('disabled', true);
		var $button_submit = $bootbox.find('button.submit');
		var id = $(this).attr('data-id-menu');
		$.get(current_url + '/checkbox?id=' + id, function(html){
			$button.prop('disabled', false);
			$bootbox.find('.modal-body').empty().append(html);
		});
	});
});