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

function removeFarmerFertilizer(obj){
    $(obj).closest("div.rowFertilizer").remove();
}
function allocationFertilizer(){
    var dataSubmit = [];
    $.each($(".rowFertilizer"), function(i, row){
        dataSubmit.push({
            farmer_id: $("#farmer_id").val(),
            season_id:$("#season_id").val(),
            batch_id:$("#batch_id").val(),
            fertilizer_id: $(row).find("[name=fertilizer_id]").val(),
            quantity: $(row).find("[name=quantity]").val(),
        });
    });
    $.ajax({
        url: $("#urlAllocationFertilizer").attr('href'),
        type:"POST",
        async: false,
        data: {
            dataSubmit:dataSubmit,
            _csrfToken: $("[name=_csrfToken]").val(),
            farmer_id: $("#farmer_id").val(),
            batch_id:$("#batch_id").val(),
        },
        success:function(data){
            location.href = $("#urlFarmersIndex").attr("href");
        }
    });
}

function selectFertilizerChange(obj){
    $.ajax({
        url: $("#urlApiFertilizer").attr('href')+"/get/"+$(obj).val(),
        type: "GET",
        dataType:'json',
        success:function(data){
            var rowFertilizer = $(obj).closest(".rowFertilizer");
            var unit = $(rowFertilizer).find(".unit-fertilizer");
            unit.html(data.fertilizer.unit);
        }
    });
}
function addFarmerFertilizer(){
    var selectfertilizerBefores = [];
    $.each($(".select-fertilizer") , function(i, selectfertilizerBefore){
        selectfertilizerBefores.push($(selectfertilizerBefore).val());
    });
    $.ajax({
        url: $("#urlApiFertilizer").attr('href'),
        type: "GET",
        async: false,
        data:{
            ward_id:$("#ward_id").val(),
            selectfertilizerBefores: selectfertilizerBefores
        },
        dataType:'json',
        success:function(data){
            if(data.fertilizers.length > 0){
                var rowFertilizer = `
                    <div class="row rowFertilizer"> 
                        <div class="col-md-6">
                            <select class='select-fertilizer' onclick='selectFertilizerChange(this)' name='fertilizer_id'>`;
                $.each(data.fertilizers, function (i, fertilizer){
                    rowFertilizer+= `<option value='`+fertilizer.id+`'>`+fertilizer.name+`</option>`;
                });
                rowFertilizer+=`</select></div>
                        <div class="col-md-3">
                            <div class="input text">
                                <label for="quantity"></label>
                                <input type="text" name="quantity" class="text-right w-75 pull-left" min="0" id="quantity" value="0">
                            </div>
                            <span class='unit-fertilizer'>`+data.fertilizers[0].unit+`</span>
                        </div>
                        <div class="col-md-2">
                            <a onclick="removeFarmerFertilizer(this)"><i class="fa fa-remove"></i></a>
                        </div>
                    </div>
                `;
                var rowFertilizerObj = $(rowFertilizer);
                $("#divFertilizer").append(rowFertilizerObj);
            } else {
                alert("Số lượng chủng loại phân đã đạt giới hạn!!!");
            }
        }
    });
}

function dateFormat(date){
    var day = date.getDate();
    if(parseInt(day)<10) day = "0" + day;
    var month = date.getMonth() + 1;
    if(parseInt(month)<10) month = "0" + month;
    return day + "-" + month + "-" + date.getFullYear();
}

function editFarmer($id){
    location.href = $("#urlFarmers").attr("href") + "/add"; 
}

function allocationFarmer($farmerId, $batchId){
    location.href = $("#urlFarmerFertilizers").attr("href") + "/add" + "/" + $farmerId + "/" + $batchId; 
}

function lockfarmerfertilizer($batchId, $isLock){
    location.href = $("#urlBatchs").attr("href") + "/lock-farmer-fertilizer" + "/" + $batchId + "/" + $isLock; 
}

function str_to_slug(str)
{
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();     
 
    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
 
    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');
 
    // Xóa khoảng trắng thay bằng ký tự -
    // str = str.replace(/(\s+)/g, '-');
 
    // xóa phần dư - ở đầu
    str = str.replace(/^-+/g, '');
 
    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');
 
    return str;
}

function number_format(number){
    number = number.toString();
    if(number=='125000') console.log(number);
    var length = number.length;
    var result = "";
    for (var i = 0; i < length; i++) {
        result += number.charAt(length-1-i);
        if(i%3==2 && i!=length-1) result+=",";
    }
    return result.split("").reverse().join("");
}

