View = Backbone.View.extend({
	initialize : function() {
		$('.btimport').click(function(e) {
			var qid = $(this).attr('id');

			var data = 'qid=' + qid;
			Backbone.ajax({
				type: "POST",
				url : "view",
				data : data,
				success : function(response) {
					$('#messages div').html(response);
				},
				error : function(e) {
					/* handle the error code here */
					console.log(e);
				}
			});
		});	
	}
});

var view = new View({
	el : $(".content-box-content")
});
