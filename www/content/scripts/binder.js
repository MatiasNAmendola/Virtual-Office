/**
 * Javascript class for Web Office
 * binder for pages
 * Created by Mihael Isaev
 */


binder = {}

binder.loginForm = function() {
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
};

binder.page = function(key){
    switch(key){
        case 'cabinet':
            /* Top menu logo */
            $('.office .head .logo').click(function(){
                $('.office .head .logo').addClass('active');
                $('.office .head .logo ul').show();
            });
            $('.office .head .logo').mouseleave(function(){
                $('.office .head .logo').removeClass('active');
                $('.office .head .logo ul').hide();
            });
            /* END - Top menu logo */

            /* Top menu binds */
            $('.office .head .logo .staff').click(function(){
                page.load('staff', true);
            });
            $('.office .head .logo .log').click(function(){
                page.load('log', true);
            });
            $('.office .head .logo .tasks').click(function(){
                page.load('tasks', true);
            });
            $('.office .head .logo .settings').click(function(){
                page.load('settings', true);
            });
            $('.office .head .logo .logout').click(function(){
                auth.logout();
            });
            /* END - Top menu binds */

            /* Resizer for cabinet div's */
            $(window).resize(function(){
                system.resizeCabinetDivs();
            });
            /* END - Resizer for cabinet div's */
            break;
    }
}