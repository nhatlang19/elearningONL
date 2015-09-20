View = Backbone.View.extend({
	dom: {
		$errorMsgQues: $('#errorMsgQues'),
		$errorMsgAns: $('#errorMsgAns')
	},
	initialize : function() {
		this.dom.$errorMsgQues.hide();
		this.dom.$errorMsgAns.hide();
	},
	events : {
		"click #submit" : "doSubmit",
		"change #type": "doChangeType",
		"click .checkbox-answer": "doAnswer",
		"click .checkbox-answer-img": "doAnswerImage"
	},
	doSubmit: function(event) {
		// kiểm tra câu hỏi tồn tại
		var editor = $("#cke_contents_question_name iframe").contents().find("body").text();	
		if(!editor.length) {
			this.dom.$errorMsgQues.html('Hãy nhập câu hỏi');
			this.dom.$errorMsgQues.show();
			return false;
		}
		
		// kiểm tra chọn câu trả lời đúng
		var type = $('#type').val();
		if(type == 0) { // text
			var checked = $("input.checkbox-answer:checked").length;					
		} else { // image
			var checked = $("input.checkbox-answer-img:checked").length;
		}

		if(!checked) {
			this.dom.$errorMsgAns.html('Hãy chọn câu trả lời đúng');
			this.dom.$errorMsgAns.show();
			
			return false;
		}
		return true;				
	},
	doChangeType: function(event) {
		var type = event.currentTarget.value;
		if(type == 0) {
			$('.image').hide();
			$('.text').show();
		} else {
			$('.image').show();
			$('.text').hide();
		}
	},
	doAnswer: function(event) {
		var item = event.currentTarget.value;
		if(event.currentTarget.checked) {
			$("input.checkbox-answer:checked").each(function(v, e) {
				e.checked = false;
			});
			event.currentTarget.checked = true;
		}
	},
	doAnswerImage: function(event) {
		var item = event.currentTarget.value;
		if(event.currentTarget.checked) {
			$("input.checkbox-answer-img:checked").each(function(v, e) {
				e.checked = false;
			});
			event.currentTarget.checked = true;
		}
	}
});

var view = new View({
	el : $(".content-box-content")
});
