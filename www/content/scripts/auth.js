/**
 * Javascript class for Web Office
 * Created by Mihael Isaev
 */


auth = {}

/**
 * Authorization flag
 */
auth.auhorized = false;

/**
 * Authorization checker
 * @return boolean true/false
 */
auth.check = function() {
    ajax.run({
        data: ({module: 'system', action:'checkauth'}),
        json: true,
        fast:true,
        showProgressBar: true,
        onSuccess: function(data){
            if(data.status !== 'Authorized')
                auth.authorized = false;
            else
                auth.authorized = true;
            system.loadInterface();
        },
        onError: function(){
            auth.authorized = false;
            system.loadInterface();
        }
    });
}

/**
 * Function for sign in office
 */
auth.login = function() {
    ajax.run({
        data: ({module: 'system/anonymous', action:'login', login:$('.loginForm .email').val(), password:$('.loginForm .password').val()}),
        json: true,
        fast:true,
        onSuccess: function(data){
            if(data.status !== 'success'){
                    if(data.login == '')
                        $('.loginForm .email').css('background','#FFF');
                    else
                        $('.loginForm .email').css('background','#ffe4e4').focus();
                    $('.loginForm .emailInfo').html(data.login);
                    if(data.password == '')
                        $('.loginForm .password').css('background','#FFF');
                    else
                        $('.loginForm .password').css('background','#ffe4e4').focus();
                    $('.loginForm .passwordInfo').html(data.password);
                }else
                    auth.check();
        },
        onError: function(){
            auth.authorized = false;
            system.loadInterface();
        }
    });
}

/**
 * Function for staff logout from office
 */
auth.logout = function() {
    if(dialog('выйти')){
        ajax.run({
            data: ({module: 'system', action:'logout'}),
            json: true,
            fast:true,
            onSuccess: function(data){
                if(data.status == 'LoggedOut')
                    auth.check();
            },
            onError: function(){
                auth.authorized = false;
                system.loadInterface();
            }
        });
    }
}