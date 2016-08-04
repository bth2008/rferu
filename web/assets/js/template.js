jQuery(document).ready(function($) {

	$(".headroom").headroom({
		"tolerance": 20,
		"offset": 50,
		"classes": {
			"initial": "animated",
			"pinned": "slideDown",
			"unpinned": "slideUp"
		}
	});
});
jQuery(window).load(function(){
	if($(window).height()>$('.content').height() + $('footer').height() + 55)
	{
		$('.content').height($(window).height()-$('footer').height() - 55);
	}
});