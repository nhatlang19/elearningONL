$(function() {
	$('#number_question_max').val(list[$('#storage_id').val()]);

	$('#storage_id').change(function() {
		var val = $(this).val();				
		if(val != -1) {
			$('#number_question_max').val(list[val]);
		}
	});

	$('#form').submit(function() {			
		if(parseInt($('#number_question').val()) > parseInt($('#number_question_max').val())) {
			$('.error div').html('Số lượng câu hỏi không được lớn hơn ' + $('#number_question_max').val());
			return false;
		}
		return true;
	});
});
