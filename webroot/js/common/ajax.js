function ajaxCallApi(url, type, data, callback){
	var loading = $(`<div class='loader-overlay'><div class='loader'><div></div>`);
	$("body").append(loading);

	$.ajax({
		url:url,
		type:type,
		dataType:'json',
		async:false,
		data:data,
		success:function(data){
			setTimeout(function(){loading.remove();}, 300);
			if(typeof callback == 'function'){
				callback(data);
			}
		}
	});
}