View = Backbone.View.extend({
	initialize : function() {
		$('#fileupload').height('125px');
		$(document).on('change', 'input:file', function (e) {
			$('#fileupload').fileupload('add', {
		        fileInput: $('input:file')
		    });
		});
		
		$('.btimport').click(function(e) {
			var id = $(this).attr('id');
			$('.storage_id').val(id);

			// Change this to the location of your server-side upload handler:
			var url = 'uploadfile/' + id;
		    $('#fileupload').fileupload({
		        url: url,
		        //dataType: 'json',
		        add: function(e, data) {
		            var uploadErrors = [];
		            var acceptFileTypes = /^application\/(vnd.openxmlformats-officedocument.wordprocessingml.document|msword)$/i;
		            if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
		                uploadErrors.push('Only DOCX files are allowed');
		            }
		            if(data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
		                uploadErrors.push('Filesize is too big. Maximize is 5MB.');
		            }
		            if(uploadErrors.length > 0) {
		                $('<div style="padding: 10px; margin-bottom: 5px;"></div>').appendTo('.files').text(data.originalFiles[0].name + ': ' + uploadErrors.join(", ")).addClass('upload_error');
		            } else {
		                data.submit();
		            }
		   		},
		   		done: function (e, data) {
		   			var obj = jQuery.parseJSON(data.result);
		        	if(!obj.status){
						$(document).trigger('close.facebox');
						window.location = self.location;
					} else{		
						$error = data.originalFiles[0]['name'] + ': ' + obj.message;
						$('<div></div>').appendTo('.files').text($error).addClass('upload_error')
						.css('padding', '10px').css('margin-bottom', '5px');
					}
		        },
		        progressall: function (e, data) {
		            var progress = parseInt(data.loaded / data.total * 100, 10);
		            $('#progress .progress-bar').css(
		                'width',
		                progress + '%'
		            );
		        },
		        fail: function (e, data) {
		        	 $('<div class="alert alert-danger"/>')
		             .text('Upload server currently unavailable - ' +
		                     new Date())
		             .appendTo('#fileupload');
		        },
		        dragover: function (e) {
		        	$('.fileinput-button').css('border', '2px solid #92AAB0');
		        },
		        drop: function (e) {
		        	$('.fileinput-button').css('border', '2px dashed #92AAB0');
		        }
		    }).prop('disabled', !$.support.fileInput)
		        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		});	

	}
});

var view = new View({
	el : $(".content-box-content")
});
