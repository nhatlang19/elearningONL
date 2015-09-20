/* Add here all your JS customizations */
// this bit needs to be loaded on every page where an ajax POST may happen

$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
	
	if(options.type.toUpperCase() === "GET")
		return;
	
	
    var data = originalOptions.data;
    if (originalOptions.data !== undefined) {
        if (Object.prototype.toString.call(originalOptions.data) === '[object String]') {
            data = $.deparam(originalOptions.data); // see http://benalman.com/code/projects/jquery-bbq/examples/deparam/
        }
    } else {
        data = {};
    }
    options.data = $.param($.extend(data, { csrf_lph_token: $.cookie('csrf_cookie_name') }));
});