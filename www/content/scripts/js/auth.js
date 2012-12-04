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
            {
                auth.authorized = true;
                auth.firstTime = data.firstTime;
            }
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
                html.formInputColorAndError(data.login,     constants.EL_LOGIN_FORM_EMAIL,      constants.EL_LOGIN_FORM_EMAIL_INFO);
                html.formInputColorAndError(data.password,    constants.EL_LOGIN_FORM_PASSWORD,   constants.EL_LOGIN_FORM_PASSWORD_INFO);
            }else{
                auth.firstTime = data.firstTime;
                system.log('firstTime = '+data.firstTime);
                auth.check();
            }
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

/**
 * Function for staff registration
 */
auth.register = function(){
    ajax.run({
        data: ({
            module:             constants.MODULE_SYSTEM,
            action:             constants.ACTION_REGISTER,
            firstName:          $(constants.EL_REGISTER_FORM_FIRST_NAME).val(),
            secondName:         $(constants.EL_REGISTER_FORM_SECOND_NAME).val(),
            email:              $(constants.EL_REGISTER_FORM_EMAIL).val(),
            password:           $(constants.EL_REGISTER_FORM_PASSWORD).val(),
            passwordConfirm:    $(constants.EL_REGISTER_FORM_PASSWORD_CONFIRM).val(),
            invite:             $(constants.EL_REGISTER_FORM_INVITE).val(),
            captchaConfirm:     $(constants.EL_REGISTER_FORM_CAPTCHA_CONFIRM).val()
        }),
        json: true,
        fast:true,
        onSuccess: function(data){
            if(data.status !== constants.STATUS_REGISTER_SUCCESS){
                html.formInputColorAndError(data.firstName,         constants.EL_REGISTER_FORM_FIRST_NAME,          constants.EL_REGISTER_FORM_FIRST_NAME_INFO);
                html.formInputColorAndError(data.secondName,        constants.EL_REGISTER_FORM_SECOND_NAME,         constants.EL_REGISTER_FORM_SECOND_NAME_INFO);
                html.formInputColorAndError(data.email,             constants.EL_REGISTER_FORM_EMAIL,               constants.EL_REGISTER_FORM_EMAIL_INFO);
                html.formInputColorAndError(data.password,          constants.EL_REGISTER_FORM_PASSWORD,            constants.EL_REGISTER_FORM_PASSWORD_INFO);
                html.formInputColorAndError(data.passwordConfirm,   constants.EL_REGISTER_FORM_PASSWORD_CONFIRM,    constants.EL_REGISTER_FORM_PASSWORD_CONFIRM_INFO);
                html.formInputColorAndError(data.invite,            constants.EL_REGISTER_FORM_INVITE,              constants.EL_REGISTER_FORM_INVITE_INFO);
                html.formInputColorAndError(data.captchaConfirm,    constants.EL_REGISTER_FORM_CAPTCHA_CONFIRM,     constants.EL_REGISTER_FORM_CAPTCHA_CONFIRM_INFO);
            }else
                window.location.reload();
        },
        onError: function(){
            
        }
    });
}