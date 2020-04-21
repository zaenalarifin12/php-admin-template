jQuery(document).ready(function () {
	$logo_login = $('input[name="logo_login"]');
	$image_preview = $logo_login.parent().find('.upload-img-thumb');
	$('.colorpicker').spectrum({
		change: function(color) {
			// alert(color);
			hex_color = color.toHexString(); // #ff0000
			// console.log(hex_color);
			$(this).val(color);
		}
	});
	$(".colorpicker").on('move.spectrum', function(e, tinycolor) {
		$image_preview.css('background-color', tinycolor.toHexString());
		// $(e.target).val(tinycolor.toHexString());
		// console.log(tinycolor.toHexString());
	});
	
	$(".list-btn-login a").click(function(e) {

		$this = $(this);
		$ul = $this.parent().parent();
		$elm = $ul.find('a');
		$elm.each(function(i, elm) {
			$elm.find('i').remove();
			$this.append('<i class="fa fa-check check"></i>');
		});
		
		$ul.next().val($this.attr('data-class'));
		// $('#input-color-scheme').val(split);
	});
});
