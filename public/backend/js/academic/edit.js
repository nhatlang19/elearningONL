View = Backbone.View.extend({
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!$('#academic_name').val()) {
				$('.error div').html('Hãy nhập niên khóa');
				$('.error').show();
				return false;
			}
			return true;		
		}
	}
});

var view = new View({
	el : $(".content-box-content")
});
