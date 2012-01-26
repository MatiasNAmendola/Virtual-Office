/**
 * Javascript class for Web Office
 * Created by Mihael Isaev
 */

/**
 * Include child scripts
 */
$.include('/content/scripts/js/constants.js');
$.include('/content/scripts/js/html.js');
$.include('/content/scripts/js/auth.js');


system = {}

/**
 * Interface loader
 */
system.loadInterface = function() {
    if(auth.authorized)
        html.loadArea(constants.GLOBAL_AREA_CABINET);
    else
        html.loadArea(constants.GLOBAL_AREA_LOGIN);
}

system.dialog = function(subjm){
    if(confirm(constants.TEXT_CONFIRM+subjm+constants.TEXT_CONFIRM_INTERROGATION))
        return true;
    else
        return false;
}

/**
 * On document ready function
 */
$(document).ready(function(){
    auth.check();
});