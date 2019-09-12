$(document).ready(function(){
	$(".li-header-user").click(function(){
		if($(this).hasClass('open')){
			$(this).removeClass('open');
		} else {
        	event.stopPropagation();
			$(this).addClass('open');
		}
	});

    $("#village-id").change();
});

$(window).click(function() {
    $(".li-header-user").removeClass('open');
});

function charge() {
    location.href = $("#urlCharge").attr('href') + "/" + $("#season-id").val() + "/" + $("#village-id").val();
}

function villageChange(obj){
    var village_id = $(obj).val();
    $.ajax({
        url: $("#urlApiGroup").attr('href'),
        type:"GET",
        data:{
            village_id:village_id
        },
        dataType:'json',
        success: function(data){
            $("#group-id").empty();
            $("#group-id").append(`<option></option>`);

            $.each(data.groups, function(i, group){
                $("#group-id").append(`<option value='`+group.id+`'>`+group.name+`</option>`);
            });

            $("#group-id").val($('#group-id').attr('data-value')).change();
        }
    });
}