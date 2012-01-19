/**
 * Javascript class for Web Office
 * binder for pages
 * Created by Mihael Isaev
 */


html = {}

/**
 * Set HTML-code to main container
 */
html.setMainData = function(data){
    $('.mainData').html(data);
}

/**
 * Animation for login form
 */
html.slideDownLoginForm = function(){
    $('.loginForm').animate({top: 0}, 1000);
    setTimeout(function(){
        $('.loginForm form').slideDown();
    }, 1200);
}

/**
 * Animation for cabinet
 */
html.slideDownCabinetHead = function(){
    $('.head').animate({top: 0}, 1000);
}

/**
 * Function for show cabinet elements
 */
html.showCabinet = function(){
    setTimeout(function(){
        page.load('tasks', false, true);
        binder.page('cabinet');
        html.resizeCabinetDivs();
        $('.office .head .user').fadeIn('slow');
        $('.office .page').fadeIn('slow');
        $('.office .footer').fadeIn('slow');
    }, 800);
}

/**
 * Resize cabinet div's
 */
html.resizeCabinetDivs = function() {
    var headHeight = $('.office .head').outerHeight();
    var footerHeight = $('.office .footer').outerHeight();
    var windowHeight = $(window).height();
    var pageHeight = windowHeight - footerHeight - headHeight - 50;
    $('.office .page').css('height', pageHeight+'px');
}