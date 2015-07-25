View = Backbone.View.extend({
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!$('#title').val()) {
				$('.error div').html('Hãy nhập tên kho');
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
