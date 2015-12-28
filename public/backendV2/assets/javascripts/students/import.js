View = Backbone.View.extend({
	dom : {
		$class_id : $('#class_id'),
		$divError : $('.error div'),
		$classError : $('.error')
	},
	initialize : function() {
		$('.error').hide();
		if (ERROR != '') {
			$('.error div').html(ERROR);
			$('.error').show();
			ERROR = '';
		}
	},
	events : {
		"click #submit" : function(event) {
			if (this.dom.$class_id.val() == -1) {
				this.dom.$divError.html('Hãy chọn lớp');
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
