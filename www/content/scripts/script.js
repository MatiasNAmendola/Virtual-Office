$(document).ready(function(){CheckAuth();});
function CheckAuth() {	
	if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
	    $.ajax({
	        async: true,
	        cache: false,
	        type: 'POST',
	        url: '/ajax.php',
	        data: ({module: 'system', action:'checkauth'}),
	        dataType: 'json',
	        beforeSend:function(){ProgressBar("show");},
	        success: function (data, textStatus, XMLHttpRequest) {
	            if(data.status !== 'Authorized'){
	                Interface('Unauth');
	            }else{
	                Interface('Auth');
	            }
	        },
	        error: function (XMLHttpRequest, textStatus, errorThrown) {
	            alert(textStatus);ProgressBar("hide");
	        }
	    });
	}else{
		$('.ModalBackground').fadeIn();
		$('.BrowserAlert').fadeIn();
	}
}
function Logout() {
    if(dialog('выйти')){
        $.ajax({
            type: 'POST',
            url: '/ajax.php',
            data: ({module: 'system', action:'/logout'}),
            dataType: 'json',
            beforeSend:function(){ProgressBar('show');},
            success: function (data, textStatus, XMLHttpRequest) {
                if(data.status == 'LoggedOut'){
                    Interface('Unauth');
                }
            }
        });
    }
}

function ProgressBar(key){
	if(key=="show")
		if($('.ProgressBar').css('display')=='none')
			$('.ProgressBar').fadeIn('fast');
		if($('.ModalBackground').css('display')=='none')
			$('.ModalBackground').fadeIn('fast');
	if(key=="hide"){
		if($('.ProgressBar').css('display')=='block')
			$('.ProgressBar').fadeOut('fast');
		if($('.ModalBackground').css('display')=='block')
			$('.ModalBackground').fadeOut('fast');
	}
}
function ModalWindow(key,width,height,data){
    if(key=='show'){
        var marginLeft = width/2;
        $('.ModalWindow .data .info').html(data);
        $('.ModalWindow').css('width',width+'px').css('min-height',height+'px').css('margin-left','-'+marginLeft+'px').css('margin-top','200px');
        $('.ModalBackground').fadeIn('fast',function(){$('.ModalWindow').fadeIn('fast');});
    }
    if(key=='hide'){$('.ModalWindow').fadeOut('fast',function(){$('.ModalBackground').fadeOut('fast');});}
}

function LeftMenu(key) {
	$.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: ({module: 'system/'+key, action:'left_menu'}),
        dataType: 'json',
        success: function (data, textStatus, XMLHttpRequest) {
        	$('.left .data').html(data.data);
        }
    });
}
function Login(type) {
    if(type == 'Do'){
        $.ajax({
            async: true,
            cache: false,
            type: 'POST',
            url: '/ajax.php',
            data: ({module: 'system/anonymous', action:'login',login:$('.login').val(),password:$('.password').val()}),
            dataType: 'json',
            beforeSend:function(){ProgressBar('show');},
            success: function (data, textStatus, XMLHttpRequest) {
                if(data.status !== 'ok'){
                    if(data.message!==''){alert(data.message);}else{
                        if(data.login == ''){$('.login').css('background','#FFF');}else{$('.login').css('background','#ffe4e4');}
                        $('.logininfo').html(data.login);
                        if(data.password == ''){$('.password').css('background','#FFF');}else{$('.password').css('background','#ffe4e4');}
                        $('.passwordinfo').html(data.password);
                        ProgressBar('hide');
                    }
                }else{
                    ProgressBar('hide');
                    Interface('Auth');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    }else{
        SelectLeftItem(type);
        $.ajax({
            type: 'POST',
            url: '/ajax.php',
            data: ({module: 'system/anonymous', action:'login_form'}),
            dataType: 'json',
            beforeSend:function(){ProgressBar('show');},
            success: function (data, textStatus, XMLHttpRequest) {
            	ProgressBar('hide');
            	$('.right .title').html(data.title);
            	$('.right .data').html(data.data);
            }
        });
    }
}
function Registration(type) {
    if(type == 'Do'){
        $.ajax({
            async: true, cache: false, type: 'POST', url: '/ajax.php',
            data: ({module: 'system/anonymous', action:'register',
                    email:$('.email').val(),
                    login:$('.login').val(),
                    password:$('.password').val(),
                    repassword:$('.repassword').val(),
                    code:$('.code').val()}),
            dataType: 'json',
            success: function (data, textStatus, XMLHttpRequest) {
                if(data.status !== 'ok'){
                    if(data.message!==''){alert(data.message);}else{
                        if(data.email == ''){$('.email').css('background','#FFF');}else{$('.email').css('background','#ffe4e4');}
                        $('.emailinfo').html(data.email);
                        if(data.login == ''){$('.login').css('background','#FFF');}else{$('.login').css('background','#ffe4e4');}
                        $('.logininfo').html(data.login);
                        if(data.password == ''){$('.password').css('background','#FFF');}else{$('.password').css('background','#ffe4e4');}
                        $('.passwordinfo').html(data.password);
                        if(data.repassword == ''){$('.repassword').css('background','#FFF');}else{$('.repassword').css('background','#ffe4e4');}
                        $('.repasswordinfo').html(data.repassword);
                        if(data.code == ''){$('.code').css('background','#FFF');}else{$('.captcha').attr('src','/content/scripts/captcha/index.php?'+Math.random());$('.code').css('background','#ffcccc');}
                        $('.codeinfo').html(data.code);
                    }
                }else{
                    ModalWindow('show','400','20','Вы успешно зарегистрированы!<br><div class="Button" onclick="Login(\'.itemlogin\');ModalWindow(\'hide\');">OK</div>');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    }else{
        SelectLeftItem(type);
        $.ajax({
            type: 'POST', url: '/ajax.php', data: ({module: 'system/anonymous', action:'register_form'}),
            dataType: 'json',
            beforeSend:function(){ProgressBar('show');},
            success: function (data) {
                ProgressBar('hide');
                $('.right .title').html(data.title);
                $('.right .data').html(data.data);
            }
        });
    }
}
function Interface(key){
    if(key=='Unauth'){
        LeftMenu('anonymous');
        Login('Form');
    }
    if(key=='Auth'){
        LeftMenu('ui');
        Section('department');
    }
}
function Section(section){
	$.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: ({module: 'system/ui', action:section}),
        dataType: 'json',
        beforeSend:function(){ProgressBar('show');},
        success: function (data, textStatus, XMLHttpRequest) {
            ProgressBar('hide');
            $('.right .title').html(data.title);
           	$('.right .data').html(data.data);
        }
    });
}
/* End - System*/


function dialog(subjm){if(confirm('Вы действительно хотите '+subjm+'?')){return true;}else{return false;}}
function SelectLeftItem(item){
	$('.left .item').removeClass('selected');
	$(item).addClass('selected');
}


function Add(what){
    switch(what){
        case "department":
                postData = {module: 'system/ui', action:"add", name:$('.newDepartmentName').val()};
                callback = function(){Section("department");};
            break;
    }
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: (postData),
        dataType: 'json',
        beforeSend:function(){ProgressBar('show');},
        success: function (data, textStatus, XMLHttpRequest) {
            ProgressBar('hide');
            if(data.status=="ok"){
                callback();
            }
        }
    });
}

function EditStart(what, id){
    switch(what){
        case "department":
                postData = {module: 'system/ui/edit', action:"start", what:what, id:id};
                callback = function(data){$('.name'+id).html(data);};
            break;
    }
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: (postData),
        dataType: 'json',
        success: function (data, textStatus, XMLHttpRequest) {
            if(data.status=="ok"){
                callback(data.data);
            }
        }
    });
}

function EditFinish(what, id){
    switch(what){
        case "department":
                postData = {module: 'system/ui/edit', action:"finish", what:what, id:id, value:$('.departmentEdit'+id).val()};
                callback = function(data){$('.name'+id).html(data);};
            break;
    }
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: (postData),
        dataType: 'json',
        success: function (data, textStatus, XMLHttpRequest) {
            if(data.status=="ok"){
                callback(data.data);
            }
        }
    });
}

function EditCancel(what, id){
    switch(what){
        case "department":
                postData = {module: 'system/ui/edit', action:"cancel", what:what, id:id};
                callback = function(data){$('.name'+id).html(data);};
            break;
    }
    $.ajax({
        type: 'POST',
        url: '/ajax.php',
        data: (postData),
        dataType: 'json',
        success: function (data, textStatus, XMLHttpRequest) {
            if(data.status=="ok"){
                callback(data.data);
            }
        }
    });
}


/* END - Cabinet */