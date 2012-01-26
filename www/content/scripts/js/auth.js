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
        data: ({module: constants.MODULE_SYSTEM, action:constants.ACTION_CHECK_AUTH}),
        json: true,
        fast:true,
        showProgressBar: true,
        onSuccess: function(data){
            if(data.status !== constants.STATUS_LOGIN_AUTH)
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
        data: ({
            module: constants.MODULE_SYSTEM,
            action:constants.ACTION_LOGIN,
            login:$(constants.EL_LOGIN_FORM_EMAIL).val(),
            password:$(constants.EL_LOGIN_FORM_PASSWORD).val()
        }),
        json: true,
        fast:true,
        onSuccess: function(data){
            if(data.status !== constants.STATUS_LOGIN_SUCCESS){
                    if(data.login == '')
                        $(constants.EL_LOGIN_FORM_EMAIL).css(constants.CSS_BACKGROUND, constants.COLOR_WHITE);
                    else
                        $(constants.EL_LOGIN_FORM_EMAIL).css(constants.CSS_BACKGROUND, constants.COLOR_LIGHT_PINK).focus();
                    $(constants.EL_LOGIN_FORM_EMAIL_INFO).html(data.login);
                    if(data.password == '')
                        $(constants.EL_LOGIN_FORM_PASSWORD).css(constants.CSS_BACKGROUND, constants.COLOR_WHITE);
                    else
                        $(constants.EL_LOGIN_FORM_PASSWORD).css(constants.CSS_BACKGROUND, constants.COLOR_LIGHT_PINK).focus();
                    $(constants.EL_LOGIN_FORM_PASSWORD_INFO).html(data.password);
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
    if(system.dialog(constants.TEXT_CONFIRM_LOGOUT)){
        ajax.run({
            data: ({module: constants.MODULE_SYSTEM, action:constants.ACTION_LOGOUT}),
            json: true,
            fast:true,
            onSuccess: function(data){
                if(data.status == constants.STATUS_LOGIN_LOGGED_OUT)
                    auth.check();
            },
            onError: function(){
                auth.authorized = false;
                system.loadInterface();
            }
        });
    }
}