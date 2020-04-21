$(document).ready(function() {
	
	$('#table-result').find('input[type="checkbox"]').click(function(){
		checkChecked();
		
		// console.log($checked.length);
	});
	
	$('.check-all').click(function(){
		if ($(this).is(':checked')){
			$('#table-result').children('tbody').find('input[type="checkbox"]').prop('checked', this.checked);
			checkChecked();
		} else {
			$('#table-result').children('tbody').find('input[type="checkbox"]').prop('checked', false);
			checkChecked();
		}
		
		// $('#table-result').children('tbody').find('input[type="checkbox"]').trigger('click');
	})
	
	function checkChecked() {
		$checked = $('#table-result').children('tbody').find('input[type="checkbox"]:checked');
		
		if ($checked.length > 0) {
			$('#form-cetak').find('button[type="submit"]').removeClass('disabled').removeAttr('disabled');
			// $('.check-all').prop('checked', true);
		} else if ($checked.length ==0) {
			
			$('#form-cetak').find('button[type="submit"]').addClass('disabled').attr('disabled','disabled');
		}
	}
})

// alert($('.date-picker').length);