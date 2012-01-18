/**
 * Javascript class for Web Office
 * ajax function
 * Created by Mihael Isaev
 */

/**
 * Ajax short method
 */
visual = {}
/**
 * Shower for progress bar
 */
visual.showProgressBar = function() {
    if($('.progressBar').css('display')=='none')
        $('.progressBar').fadeIn('fast');
    if($('.modalBackground').css('display')=='none')
        $('.modalBackground').fadeIn('fast');
}

/**
 * Hider for progress bar
 */
visual.hideProgressBar = function() {
    if($('.progressBar').css('display')=='block')
        $('.progressBar').fadeOut('fast');
    if($('.modalBackground').css('display')=='block')
        $('.modalBackground').fadeOut('fast');
}