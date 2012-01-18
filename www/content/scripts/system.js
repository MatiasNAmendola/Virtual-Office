/**
 * Javascript class for Web Office
 * Created by Mihael Isaev
 */


system = {}

/**
 * Interface loader
 */
system.loadInterface = function() {
    if(auth.authorized)
        system.loadCabinet();
    else
        system.loadLogin();
}

/**
 * Load login html code
 */
system.loadLogin = function() {
    ajax.run({
        data: ({module: 'html', action:'login'}),
        showProgressBar: true,
        fast:true,
        onSuccess: function(data){
            $('.mainData').html(data);
            $('.loginForm').animate({top: 0}, 1000);
            setTimeout(function(){
                $('.loginForm form').slideDown();
            }, 1200);
            $('.loginForm form').submit(function(){
                auth.login();
                return false;
            });
            $('.loginForm .buttonEnter').bind('click', function(){
                auth.login();
            });
            $('.loginForm form').keypress(function(){
                if(event.keyCode == 13)
                    auth.login();
            });
        }
    });
}

/**
 * Load cabinet html code
 */
system.loadCabinet = function() {
    ajax.run({
        data: ({module: 'html', action:'cabinet'}),
        showProgressBar: true,
        fast:true,
        onSuccess: function(data){
            $('.mainData').html(data);
            $('.head').animate({top: 0}, 1000);
            setTimeout(function(){
                system.pageLoad('log', false, true);
                system.resizeCabinetDivs();
                system.showCabinetElements();
            }, 800);
            system.bindCabinet();
        }
    });
}

/**
 * Resize cabinet div's
 */
system.resizeCabinetDivs = function() {
    var headHeight = $('.office .head').outerHeight();
    var footerHeight = $('.office .footer').outerHeight();
    var windowHeight = $(window).height();
    var pageHeight = windowHeight - footerHeight - headHeight - 50;
    $('.office .page').css('height', pageHeight+'px');
}

/**
 * Fade in elements for cabinet
 */
system.showCabinetElements = function() {
    $('.office .head .user').fadeIn('slow');
    $('.office .page').fadeIn('slow');
    $('.office .footer').fadeIn('slow');
}

/**
 * Bind functions on elements for cabinet
 */
system.bindCabinet = function() {
    $('.office .head .logo .staff').click(function(){system.pageLoad('staff', true);});
    $('.office .head .logo .log').click(function(){system.pageLoad('log', true);});
    $('.office .head .logo .tasks').click(function(){system.pageLoad('tasks', true);});
    $('.office .head .logo .settings').click(function(){system.pageLoad('settings', true);});
    $('.office .head .logo .logout').click(function(){auth.logout();});
    
    $('.office .head .logo').click(function(){
        $('.office .head .logo').addClass('active');
        $('.office .head .logo ul').show();
    });
    $('.office .head .logo').mouseleave(function(){
        $('.office .head .logo').removeClass('active');
        $('.office .head .logo ul').hide();
    });
    $(window).resize(function(){system.resizeCabinetDivs();});
}

/**
 * Load page staff
 */
system.pageLoad = function(page, showProgressBar, fast) {
    ajax.run({
        data: ({module: 'html', action:page}),
        fast: fast,
        showProgressBar: showProgressBar,
        beforeSend: function(){$('.office .page').fadeOut('slow').html('');},
        onSuccess: function(data){$('.office .page').html(data).fadeIn('slow');}
    });
}






/**
 * On document ready function
 */
$(document).ready(function(){
    auth.check();
});










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
                if(data.status !== 'success'){
                    if(data.login == ''){
                        $('.login').css('background','#FFF');
                    }else{
                        $('.login').css('background','#ffe4e4').focus();
                    }
                    $('.logininfo').html(data.login);
                    if(data.password == ''){
                        $('.password').css('background','#FFF');
                    }else{
                        $('.password').css('background','#ffe4e4').focus();
                    }
                    $('.passwordinfo').html(data.password);
                    ProgressBar('hide');
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