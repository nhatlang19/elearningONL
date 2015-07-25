View = Backbone.View.extend({
	dom : {
		$title : $('#title'),
		$time: $('#time'),
		$divError: $('.error div'),
		$classError: $('.error')
	},
	initialize : function() {
		$('.error').hide();
	},
	events : {
		"click #submit" : function(event) {
			if(!this.dom.$title.val()) {
				this.dom.$divError.html('Hãy nhập hình thức thi');
				this.dom.$classError.show();
				return false;
			}

			if(!this.dom.$time.val()) {
				this.dom.$divError.html('Hãy nhập số phút');
				this.dom.$classError.show();
				return false;
			}

			var intRegex = /^\d+$/;

			var str = this.dom.$time.val();
			if(!intRegex.test(str)) {
				this.dom.$divError.html('Dữ liệu phải là số');
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
