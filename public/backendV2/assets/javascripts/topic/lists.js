View = Backbone.View.extend({
	initialize : function() {

	},
	events : {
		"click .imgDelete" : "doDelete",
		"click .tdReview" : "doReview", 
		"click .showListStudentAnswer" : "doShowListStudentAnswer", 
		"click .downloadZipFiles" : "doDownloadZipFiles"
	},
	doDelete : function(event) {
		// Button clicked, you can access the element that was clicked with
		// event.currentTarget
		var id = event.currentTarget.id;
		if (confirm('Bạn chắc chắn muốn xoá?')) {
			Backbone.ajax({
				dataType : "json",
				url : "delete/" + id,
				data : '',
				success : function(obj) {
					// collection.add(val); //or reset
					if (obj.result) {
						event.currentTarget.parentNode.parentNode.remove();
					} else {
						var html = '<h4>Thông báo</h4>';
						html += '<div><br />' + obj.message + '</div>';
						$('#messages div').html(html);
						$('#virtualLink').trigger('click');
					}
				},
				error : function(e) {
					/* handle the error code here */
					console.log(e);
				}
			});
		}
	}, 
	doReview: function(event) {
		var id = event.currentTarget.id;
		var change_to = $(event.currentTarget).data('review');
		Backbone.ajax({
			type: 'post',
			dataType : "json",
			url : "change_review",
			data : {topic_manage_id: id, change_to: change_to},
			success : function(obj) {
				if (obj.status) {
					$(event.currentTarget.parentNode).addClass(change_to);
					$(event.currentTarget.parentNode).removeClass(obj.changeTo);
					$(event.currentTarget).data('review', obj.changeTo);
					$(event.currentTarget).html(obj.reviewText);
				}
			},
			error : function(e) {
				/* handle the error code here */
				console.log(e);
			}
		});
	}, 
	doShowListStudentAnswer: function(event) {
		var id = event.currentTarget.id;
		Backbone.ajax({
			type: 'post',
			dataType : "json",
			url : "get_list_for_download",
			data : {topic_manage_id: id},
			success : function(obj) {
				if (!obj.status) {
					$('#files div').html(obj.message);
					$('#virtualfiles').trigger('click');
				}
			},
			error : function(e) {
				/* handle the error code here */
				console.log(e);
			}
		});
	},
	doDownloadZipFiles: function(event) {
		var id = event.currentTarget.id;
		var folder = $(event.currentTarget).data('folder');
		console.log(id);
	}
});

var view = new View({
	el : $(".content-box-content")
});