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
    
    $('.answers li input[type=checkbox]').click(function(e) {
    	var arrayAnswer = ['A', 'B', 'C', 'D', 'E', 'F'];
    	
    	var id = $(this).attr('id');
    	var array = id.split('_');
    	id = array[0];
    	var numberQuestion = parseInt(id.replace('question', '')) + 1;
    	var answer = arrayAnswer[$(this).val()];
    	
    	var currentAnswer = $('.td-' + id).html();
    	
    	// get number question
    	var data = currentAnswer.split('.');
    	var numberQuestion = data[0] + '.';
    	currentAnswer = currentAnswer.replace(numberQuestion, '');
    	var arrayCurrentAnswer = [];
    	if(currentAnswer) {
    		arrayCurrentAnswer = currentAnswer.split(',');
    	}
    	
    	var index = $.inArray(answer, arrayCurrentAnswer);
    	if(index == -1) {
    		arrayCurrentAnswer.push(answer);
    	} else {
    		arrayCurrentAnswer = arrayCurrentAnswer.filter(function(item) { 
    			return item !== answer; 
    		});
    	}
    	var answerString = arrayCurrentAnswer.sort().toString();
    	$('.td-' + id).html(numberQuestion + answerString);
    });
    
});