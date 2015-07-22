$(function () {
	$('.logout').click(function(e) {
		_LOGOUT = true;
    	$.removeCookie(_CNAME, { path: '/' });
    	location.href = BASEURL + 'logout';
    });
});
