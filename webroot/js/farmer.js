$(document).ready(function(){
	if(localStorage.dataSearch != undefined) {
		var dataSearch = JSON.parse(localStorage.dataSearch);
		
		$("#village-id").val(dataSearch.village_id).change();
		$("#group-id").val(dataSearch.group_id).change();
		$("#season-id").val(dataSearch.season_id).change();
	}
	filterFarmer(localStorage.page);
});

function filterFarmer(page){
	var dataSearch = {
		'ward_id': $("#ward_id").val(),
		'village_id': $("#village-id").val(),
		'group_id': $("#group-id").val(),
		'season_id': $("#season-id").val(),
		'authenticate': sessionStorage.authenticate
	};
	localStorage.dataSearch = JSON.stringify(dataSearch);

	ajaxCallApi($("#urlApiFarmers").attr('href'), 'POST', dataSearch, function(data){
		renderTrHead(data.response.batchs);
		if(page == undefined) page = 1;
		var limit = 7;
		var paginator = {
			'limit' : limit,
			'count' : data.response.farmers.length,
			'page' : page,
			'screen' : 'farmer'
		};
		renderPaginate(data.response.farmers, paginator);

		renderSearch(data.response.farmers, paginator);
	});
}
