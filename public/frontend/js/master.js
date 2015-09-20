// Put all your page JS here

$(function () {
    $('#slickQuiz').slickQuiz();
    
    $('.answers li input[type=radio]').click(function(e) {
    	var arrayAnswer = ['A', 'B', 'C', 'D', 'E', 'F'];
    	
    	var id = $(this).attr('id');
    	var array = id.split('_');
    	id = array[0];
    	var numberQuestion = parseInt(id.replace('question', '')) + 1;
    	var answer = arrayAnswer[$(this).val()];
    	$('.td-' + id).html(numberQuestion + '. ' + answer);
    });
    
});