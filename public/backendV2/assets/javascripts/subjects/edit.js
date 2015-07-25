View = Backbone.View.extend({
	dom : {
		$subjects_name : $('#subjects_name'),
		$divError: $('.error div'),
		$classError: $('.error')
	},
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!this.dom.$subjects_name.val()) {
				this.dom.$divError.html('Hãy nhập môn học');
				this.dom.$classError.show();
				return false;
			}

			return true;		
		}
	}
});

var view = new View({
	el : $(".content-box-content")
});
