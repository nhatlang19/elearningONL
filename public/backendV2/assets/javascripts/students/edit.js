View = Backbone.View.extend({
	dom : {
		$fullname : $('#fullname'),
		$indentity_number : $('#indentity_number'),
		$username : $('#username'),
		$class_id : $('#class_id'),
		$divError: $('.error div'),
		$classError: $('.error')
	},
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!this.dom.$indentity_number.val()) {
				this.dom.$divError.html('Hãy nhập mã học sinh');
				this.dom.$classError.show();
				return false;
			}
			if(!this.dom.$fullname.val()) {
				this.dom.$divError.html('Hãy nhập tên học sinh');
				this.dom.$classError.show();
				return false;
			}
			if(!this.dom.$username.val()) {
				this.dom.$divError.html('Hãy nhập tên đăng nhập');
				this.dom.$classError.show();
				return false;
			}
			if(!this.dom.$class_id.val() == -1) {
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
