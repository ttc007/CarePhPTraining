$(document).ready(function(){
	filterFarmer();
});

function filterFarmer(){
	$.ajax({
		url:$("#urlApiFarmers").attr('href'),
		type:"POST",
		data:{
			ward_id: $("#ward_id").val(),
			village_id: $("#village-id").val(),
			group_id: $("#group-id").val(),
			season_id: $("#season-id").val()
		},
		dataType:'json',
		success:function(data){
			renderTrHead(data.response.batchs);

			var limit = 7;
			var paginator = {
				'limit' : limit,
				'count' : data.response.farmers.length,
				'page' : 1
			};
			renderPaginate(data.response.farmers, paginator);

			renderSearch(data.response.farmers, paginator);
		}
	});
}

function renderTrHead(batchs){
	var trHead = $("#thead-farmer");
	trHead.empty();
	trHead.css("background", "#f6f6f6");
	trHead.append(`<th style="width: 50px">STT</th><th>Nông hộ</th>`);
	
	$.each(batchs, function (b, batch){
		var th = $(`<th>`+batch.name+` (`+ dateFormat(new Date(batch.date_provide)) +`) </th>`);
		if(batch.isLock) {
			th.append(`<a onclick='lockfarmerfertilizer(`+batch.id+`, 0)' class="lock-farmer-fertilizer">Mở sổ</a>`);
		} else {
			th.append(`<a onclick='lockfarmerfertilizer(`+batch.id+`, 1)' class="lock-farmer-fertilizer">Khóa sổ</a>`);
		}
		trHead.append(th);
	});
}



function renderPaginate(farmers, paginator){
	var paginate = $(".paginate");
	renderTbody(farmers, paginator);

	paginate.empty();
	var ulPaginate = $("<ul class='ul-paginate'></ul>");

	renderPrev(ulPaginate, paginator, farmers);
	renderNumber(ulPaginate, paginator, farmers);
	renderNext(ulPaginate, paginator, farmers);
	renderPageCount(paginate, paginator);
	paginate.append(ulPaginate);
}



function renderTbody(farmers, paginator){
	var tbody = $("#tbody-farmer");
	tbody.empty();
	$.each(farmers, function (i, farmer){
		var styleTr = '';
		if(i % 2 == 0){
			styleTr = 'style="background:#f6f6f6"';
		}
		var page = parseInt(i/paginator.limit)+1;
		if(page == paginator.page) {
			var tr = `<tr `+ styleTr +` class='page-`+page+`'>
                <td>`+(i+1)+`</td>
                <td>
                    <a onclick='editFarmer(`+ farmer.id +`)' class="link">`+ farmer.name +`</a><br>
                    Mã số: <a onclick='editFarmer(`+ farmer.id +`)' class="link">`+ farmer.id +`</a><br>
                    Số điện thoại: `+ farmer.phone +`<br>
                    Địa chỉ: `+ farmer.village.name +` - `+ (farmer.group?farmer.group.name:"") +`
                </td>`;
	        $.each(farmer.batchs, function(j, batchData){
	        	tr += `<td>`;
	        	$.each(batchData.data, function (k, farmerfertilizer){
	        		tr += farmerfertilizer.fertilizer.name + ":" + farmerfertilizer.quantity + " " + farmerfertilizer.unit + "<br>";
	        	});
	        	if(!batchData.batch.isLock)tr += `<a onclick='addFarmerFertilizer(`+ farmer.id +`, `+ j +`)' class="link">+</a></td>`;
	        });
	        tr += `</tr>`;
			tbody.append(tr);
		}
	});
}
function renderPrev(ulPaginate, paginator, farmers){
	if(paginator.page>1) {
		var li = $("<li>");
		var a = $("<a>«</a>");;
		li.append(a);
		ulPaginate.append(li);

		a.click(function(){
			paginateClick(paginator.page-1, farmers, paginator);
		});
	} else {
		ulPaginate.append(`<li class='disabled'><a>«</a></li>`);
	}
}
function renderNext(ulPaginate, paginator, farmers){
	if(paginator.page<paginator.pageCount) {
		var li = $("<li>");
		var a = $("<a>»</a>");
		li.append(a);
		ulPaginate.append(li);

		a.click(function(){
			paginateClick(paginator.page+1, farmers, paginator);
		});
	} else {
		ulPaginate.append(`<li class='disabled'><a>»</a></li>`);
	}
}
function renderNumber(ulPaginate, paginator, farmers){
	var pageCount = parseInt(paginator.count/paginator.limit) + (paginator.count%paginator.limit==0?0:1);
	for (var i = 1; i <= pageCount; i++) {
		if(i == paginator.page){
			ulPaginate.append(`<li class='active'><a>`+i+`</a></li>`);
		} else {
			var li = $("<li>");
			var a = $("<a>"+i+"</a>");
			li.append(a);
			ulPaginate.append(li);

			a.click(function(){
				paginateClick( parseInt($(this).text()) , farmers, paginator);
			});
		}
	}
}

function renderPageCount(ulPaginate, paginator){
	var index = (paginator.page-1)*paginator.limit + 1;
	var end = paginator.page*paginator.limit;
	if(end>paginator.count) end = paginator.count;

	var paginateCount = $("<div class='paginate-count'>Danh sách "+ index + "-" + end + " của " + paginator.count+"</div>");
	ulPaginate.append(paginateCount);
}

function paginateClick(page, farmers, paginator){
	paginator.page = page;
	renderPaginate(farmers, paginator);
}

function renderSearch(farmers, paginator){
	$("#search-form-div").empty();
	$("#search-form-div").append("Tìm kiếm")
	var inputSearch = $(`<input placeholder='Nhập tên nông hộ muốn tìm kiếm...' class='search-input'/>`);
	$("#search-form-div").append(inputSearch);

	inputSearch.keyup(function(){
		var key = str_to_slug($(this).val());
		var farmerSearchs = [];
		$.each(farmers, function(i, farmer){
			var farmerName = str_to_slug(farmer.name);
			var firstIndex = farmerName.indexOf(key);
			if(firstIndex>=0){
				farmerSearchs.push(farmer);
			}
		});

		paginator.count = farmerSearchs.length;
		renderPaginate(farmerSearchs, paginator);
		$(window).scrollTop(0);
	});
}