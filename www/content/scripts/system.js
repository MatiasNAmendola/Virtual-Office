/**
 * Javascript class for Web Office
 * Created by Mihael Isaev
 */

/**
 * Include child scripts
 */
$.include('/content/scripts/constants.js');
$.include('/content/scripts/visual.js');
$.include('/content/scripts/ajax.js');
$.include('/content/scripts/helper.js');
$.include('/content/scripts/html.js');
$.include('/content/scripts/auth.js');


system = {}

/**
 * Interface loader
 */
system.loadInterface = function() {
    if(auth.authorized)
        html.loadArea(constants.AREA_CABINET);
    else
        html.loadArea(constants.AREA_LOGIN);
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