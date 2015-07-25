View = Backbone.View.extend({
	initialize : function() {
		$('.btimport').click(function(e) {
			var qid = $(this).attr('id');
			
			$.ajax({
				type: "POST",
				url : "view",
				data : {qid : qid},
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
