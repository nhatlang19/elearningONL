View = Backbone.View.extend({
	dom : {
		$class_name : $('#class_name'),
		$divError: $('.error div'),
		$classError: $('.error')
	},
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!this.dom.$class_name.val()) {
				this.dom.$divError.html('Hãy nhập lớp học');
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
