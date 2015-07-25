View = Backbone.View.extend({
	dom : {
		$username : $('#username'),
		$password : $('#password'),
		$email : $('#email'),
		$combobox : $('#combobox'),
		$id: $('#id'),
		$divError: $('.error div'),
		$classError: $('.error')
	},
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!this.dom.$username.val()) {
				this.dom.$divError.html('Hãy nhập tên đăng nhập');
				this.dom.$classError.show();
				return false;
			}

			if(this.dom.$id != '' && !this.dom.$password.val()) {
				this.dom.$divError.html('Hãy nhập mật khẩu');
				this.dom.$classError.show();
				return false;
			}
			
			if(!this.dom.$email.val()) {
				this.dom.$divError.html('Hãy nhập email');
				this.dom.$classError.show();
				return false;
			}
			
			if(!this.dom.$combobox.val() == -1) {
				this.dom.$divError.html('Hãy chọn môn dạy');
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
