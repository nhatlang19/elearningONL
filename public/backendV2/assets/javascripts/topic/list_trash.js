View = Backbone.View.extend({
	initialize : function() {

	},
	events : {
		"click .imgRestore" : "doRestore"
	},
	doRestore : function(event) {
		// Button clicked, you can access the element that was clicked with
		// event.currentTarget
		var id = event.currentTarget.id;
		if (confirm('Bạn chắc chắn muốn phục hồi?')) {
			Backbone.ajax({
				dataType : "json",
				url : "restore/" + id,
				data : '',
				success : function(obj) {
					// collection.add(val); //or reset
					if (obj.result) {
						event.currentTarget.parentNode.parentNode.remove();
					}
				},
				error : function(e) {
					 // handle the error code here 
					console.log(e);
				}
			});
		}
	}
});

var view = new View({
	el : $(".content-box-content")
});
