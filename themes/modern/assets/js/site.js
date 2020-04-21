/**
* Written by: Agus Prawoto Hadi
* Year		: 2020
* Website	: jagowebdev.com
*/

jQuery(document).ready(function () {
	$('.has-children').mouseenter(function(){
		$(this).children('ul').stop(true, true).fadeIn('fast');
	}).mouseleave(function(){
		$(this).children('ul').stop(true, true).fadeOut('fast');
	});
	
	$('.has-children').click(function(){
		var $this = $(this);
		$(this).next().stop(true, true).slideToggle('fast', function(){
			$this.parent().toggleClass('tree-open');
		});
		return false;
	});
	
	$('#mobile-menu-btn').click(function(){
		$('body').toggleClass('mobile-menu-show');
		return false;
	});
	$('#mobile-menu-btn-right').click(function(){
		$('header').toggleClass('mobile-right-menu-show');
		return false;
	});
	$('.profile-btn').click(function(){
		$(this).next().stop(true, true).fadeToggle();
		return false;
	});
	
	// DELETE
	$('[data-action="delete-data"]').click(function(e){
		e.preventDefault();
		var $this =  $(this)
			, $form = $this.parents('form:eq(0)');
		bootbox.confirm({
			message: $this.attr('data-delete-title'),
			callback: function(confirmed) {
				if (confirmed) {
					$form.submit();
				}
			}
		});
	})
	
	$('.sidebar').overlayScrollbars({scrollbars : {autoHide: 'leave', autoHideDelay: 100} });
	
	$('.file').change(function(e) 
	{
		file = this.files[0];
		$this = $(this);

		var reader = new FileReader();

		// Closure to capture the file information.
		var $upload_img = $this.parent().children('.upload-img-thumb');
		
		reader.onload = (function(e) {

			// Render thumbnail.
			$upload_img.find('img').remove();
			var thumb = '<img class="thumb" src="' + e.target.result +
                            '" title="' + escape(file.name) + '"/>';
			$upload_img.find('span').before(thumb);
			
		});
		
		reader.readAsDataURL(file); 
		size = file.size;
		
		file_size = size + ' Bytes';
		if (size > 1024 * 1024) {
			file_size = parseFloat(size / (1024 * 1024)).toFixed(2) + ' Mb';
		} else if (size > 1024) {
			file_size = parseFloat(size / 1024).toFixed(2) + ' Kb';
		}
		// console.log(file);
		if (size > 1024 * 300) {
			$('<small class="alert alert-danger">Ukuran file maksimal: 300 KB, file Anda ' + file_size + '</small>').insertAfter($this);
			return;
		}
		
		if (file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/jpeg') {
			$('<small class="alert alert-danger">Tipe file yang diperbolehkan: .JPG, .JPEG, dan .PNG</small>').insertAfter($this);
			return;
		}
		// console.log($upload_img.attr('class'));
		var file_prop = '<ul><li><small>Name: ' + file.name + '</small></li><li><small>Size: ' + file_size + '</small></li><li><small>Type: ' + file.type + '</small></li></ul>';
		$upload_img.show().find('span').html(file_prop);
	});
});