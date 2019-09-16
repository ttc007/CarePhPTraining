function login(e){
	if(validateLogin()){
		var data = {
			'username': $("#username").val(),
			'password': MD5($("#password").val()),
		}
		
		ajaxCallApi($("#urlApiUser").attr('href')+"/login", 'POST', data, function(data){
			if(data.status == 200 ){
				sessionStorage.authenticate = data.authenticate;
				location.href = $("#urlFarmers").attr("href");
			} else {
	            addErrorMsg('Sai tên đăng nhập hoặc mật khẩu.<br>', 'container-form');
			}
		});
	}
}

$("input").click(function(e){
	alert(123);
	alert($(this).val());
	console.log(e);
});

function register(){
	var data = {
		'username': $("#username").val(),
		'password': MD5($("#password").val()),
		'ward': $("#ward").val()
	}
	if(validateRegister()){
		ajaxCallApi($("#urlApiUser").attr('href')+"/add", 'POST', data, function(data){
			localStorage.registerMsg = "1";
			location.href = 'login';
		});
	}
}

function checkLogin(){
	if(sessionStorage.authenticate!=undefined){
		var data = {
			'authenticate' : sessionStorage.authenticate
		}
		ajaxCallApi($("#urlApiUser").attr('href')+"/checklogin", 'POST', data, function(data){
			if(data.status == 'isLogin' ){
				location.href = $("#urlFarmers").attr("href");
			}
		});
	}
}

function logout(){
	var data = {
		'authenticate' : sessionStorage.authenticate
	}
	ajaxCallApi($("#urlApiUser").attr('href')+"/logout", 'POST', data, function(data){
		if(data.status == 200 ){
			sessionStorage.removeItem('authenticate');
			location.href = $("#urlUser").attr("href") + "/login";
		}
	});	
}

function middlewareUser(){
	if(sessionStorage.authenticate!=undefined){
		var data = {
			'authenticate' : sessionStorage.authenticate
		}
		ajaxCallApi($("#urlApiUser").attr('href')+"/checklogin", 'POST', data, function(data){
			if(data.status != 'isLogin' ){
				location.href = $("#urlUser").attr("href") + "/login";
			}
		});
	} else {
		location.href = $("#urlUser").attr("href") + "/login";
	}
}

function addError(idInput, msgError){
	var x = document.getElementById(idInput); 
	x.classList.add("error");
    var txt = document.createTextNode(msgError);
    var paragraph = document.createElement("p");paragraph.classList.add("msg-error");paragraph.classList.add("mt-2");
    paragraph.appendChild(txt);
    $(x.parentNode).find("p").remove();
    x.parentNode.appendChild(paragraph);
}

function clearError(){
	$(".error").removeClass("error");
	$(".msg-error").remove();
}

function validateRegister(){
	var loading = $(`<div class='loader-overlay'><div class='loader'><div></div>`);
	$("body").append(loading);

	var validate = true;

	clearError();

	var username = $("#username").val();
	if(username.indexOf(" ")>-1){
		addError("username", "* Tên đăng nhập không được có khoảng trắng");
		validate = false;
	} else if(username=="") {
		addError("username", "* Tên đăng nhập là bắt buộc.");
		validate = false;
	} else if(username.length < 8) {
		addError("username", "* Tên đăng nhập ít nhất 8 kí tự.");
		validate = false;
	}

	var password = $("#password").val();
	if(password.indexOf(" ")>-1){
		addError("password", "* Mật khẩu không được có khoảng trắng");
		validate = false;
	} else if(password=="") {
		addError("password", "* Mật khẩu là bắt buộc.");
		validate = false;
	} else if(password.length < 6) {
		addError("password", "* Mật khẩu ít nhất 6 kí tự.");
		validate = false;
	}

	var confirmpassword = $("#confirmpassword").val();
	if(confirmpassword.indexOf(" ")>-1){
		addError("confirmpassword", "* Mật khẩu xác nhận không được có khoảng trắng");
		validate = false;
	} else if(confirmpassword=="") {
		addError("confirmpassword", "* Mật khẩu xác nhận là bắt buộc.");
		validate = false;
	} else if(confirmpassword!=password){
		addError("confirmpassword", "* Mật khẩu xác nhận không khớp.");
		validate = false;
	}

	var ward = $("#ward").val();
	if(ward=="") {
		addError("ward", "* Tên xã/thị trấn là bắt buộc.");
		validate = false;
	} else if(ward.length < 6) {
		addError("ward", "* Tên xã/thị trấn ít nhất 6 kí tự.");
		validate = false;
	}

	setTimeout(function(){loading.remove();}, 300);
	return validate;
}

function validateLogin(){
	var loading = $(`<div class='loader-overlay'><div class='loader'><div></div>`);
	$("body").append(loading);

	var validate = true;

	clearError();

	var username = $("#username").val();
	if(username.indexOf(" ")>-1){
		addError("username", "* Tên đăng nhập không được có khoảng trắng");
		validate = false;
	} else if(username=="") {
		addError("username", "* Tên đăng nhập là bắt buộc.");
		validate = false;
	} else if(username.length < 8) {
		addError("username", "* Tên đăng nhập ít nhất 8 kí tự.");
		validate = false;
	}

	var password = $("#password").val();
	if(password.indexOf(" ")>-1){
		addError("password", "* Mật khẩu không được có khoảng trắng");
		validate = false;
	} else if(password=="") {
		addError("password", "* Mật khẩu là bắt buộc.");
		validate = false;
	} else if(password.length < 6) {
		addError("password", "* Mật khẩu ít nhất 6 kí tự.");
		validate = false;
	}

	setTimeout(function(){loading.remove();}, 300);
	return validate;
}

function addSuccess(msg, targetId){
	$(".alert").remove();
	setTimeout(function(){
		var msgDiv = $(`<div class="alert alert-success alert-dismissible">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  `+ msg +`
		</div>`);
		$("#"+targetId).prepend(msgDiv);
	},200);
}

function addErrorMsg(msg, targetId){
	$(".alert").remove();
	setTimeout(function(){
		var msgDiv = $(`<div class="alert alert-danger alert-dismissible">
		  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  `+ msg +`
		</div>`);
		$("#"+targetId).prepend(msgDiv);
	},200);
	
}

$(document).keyup(function(event) {
    if ($("input").is(":focus") && event.key == "Enter") {
        var action = $(event.target).closest("form").attr('onsubmit');
        window[action]();
    }
});
