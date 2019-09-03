$(document).ready(function(){
	$(".li-header-user").click(function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open');
		} else {
        	event.stopPropagation();
			$(this).addClass('open');
		}
	});
});

$(window).click(function() {
    $(".li-header-user").removeClass('open');
});