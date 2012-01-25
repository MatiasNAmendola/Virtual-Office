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
    $(constants.EL_MAIN_DATA).html(data);
}

html.resize = function(key){
    switch(key){
        case constants.GLOBAL_AREA_CABINET:
            var headHeight = $(constants.EL_OFFICE_HEAD).outerHeight();
            var footerHeight = $(constants.EL_OFFICE_FOOTER).outerHeight();
            var windowHeight = $(window).height();
            var pageHeight = windowHeight - footerHeight - headHeight - 50;
            $(constants.EL_OFFICE_PAGE).css(constants.CSS_HEIGHT, pageHeight+constants.CSS_PX);
        break;
        case constants.SECTION_RIGHT:
            html.resizeSectionRight();
        break;
        case constants.PAGE_WIZARD:
            html.resizeSectionRight();
        break;
    }
}

html.loadArea = function(area){
    ajax.run({
        data: ({module: constants.MODULE_HTML_GLOBAL_AREA, action:area}),
        showProgressBar: true,
        fast:true,
        onSuccess: function(data){
            html.setMainData(data);
            html.afterLoadArea(area);
        }
    });
}

html.afterLoadArea = function(area){
    switch(area){
        case constants.GLOBAL_AREA_LOGIN:
            $(constants.EL_LOGIN_FORM).animate({top: 0}, 1000);
            setTimeout(function(){$(constants.EL_LOGIN_FORM_FORM).slideDown();}, 1200);
            html.bind(area);
        break;
        case constants.GLOBAL_AREA_CABINET:
            $(constants.EL_OFFICE_HEAD).animate({top: 0}, 1000);
            setTimeout(function(){
                var firstItemInMenu = $(constants.EL_OFFICE_HEAD_LOGO_MENU_ITEM).first().attr(constants.ATTR_CLASS);
                html.load(firstItemInMenu, false, true, true);
                html.resize(area);
                html.bind(area);
                $(constants.EL_OFFICE_HEAD_USER).fadeIn(constants.SPEED_SLOW);
                $(constants.EL_OFFICE_PAGE).fadeIn(constants.SPEED_SLOW);
                $(constants.EL_OFFICE_FOOTER).fadeIn(constants.SPEED_SLOW);
            }, 800);
        break;
    }
}

/**
 * Loader pages
 * @param page - name of page
 * @param showProgressBar - boolean true/false show progressBar or not
 * @param fast - boolean true/false faster loading or with timeout
 * @param resizeRight - boolean true/false resize right divs
 */
html.load = function(page, showProgressBar, fast, resizeRight) {
    ajax.run({
        data: ({module: constants.MODULE_HTML_AREA, action: page}),
        fast: fast,
        showProgressBar: showProgressBar,
        beforeSend: function(){
            $(constants.EL_OFFICE_PAGE).fadeOut(constants.SPEED_SLOW).html('');
        },
        onSuccess: function(data){
            $(constants.EL_OFFICE_PAGE).html(data).fadeIn(constants.SPEED_SLOW);
            html.resize(page);
            if(resizeRight){
                html.resize(constants.SECTION_RIGHT);
                html.bind(constants.SECTION_RIGHT);
            }
            html.bind(page);
        }
    });
}

html.loadWizard = function(page) {
    ajax.run({
        data: ({module: constants.MODULE_HTML_WIZARD, action: page}),
        showProgressBar: true,
        beforeSend: function(){
            $(constants.EL_OFFICE_PAGE).fadeOut(constants.SPEED_SLOW).html('');
        },
        onSuccess: function(data){
            $(constants.EL_OFFICE_PAGE).html(data).fadeIn(constants.SPEED_SLOW);
            html.resize(constants.PAGE_WIZARD);
            html.bind(constants.PAGE_WIZARD);
        }
    });
}

html.bind = function(key){
    /* Left menu items bind */
    if($(constants.EL_OFFICE_PAGE_MENU).length)
        $(constants.EL_OFFICE_PAGE_MENU_ITEM).each(function(i) {
            $(this).unbind().click(function(){
                $(constants.EL_OFFICE_PAGE_MENU_ITEM).removeClass(constants.CLASS_NAME_ACTIVE);
                $(this).addClass(constants.CLASS_NAME_ACTIVE);
                if($(constants.EL_OFFICE_PAGE_RIGHT_VS).length){
                    var rightHeight = $(constants.EL_OFFICE_PAGE_RIGHT).height();
                    var topPosition = rightHeight*i;
                    $(constants.EL_OFFICE_PAGE_RIGHT_VS).animate({top:'-'+topPosition+constants.CSS_PX},500);
                }
            });
        });
    if($(constants.EL_OFFICE_PAGE_RIGHT_VS).length)
        $(constants.EL_OFFICE_PAGE_RIGHT_VS_ITEM).each(function(i) {
            $(this).children('.topMenu').children('li').each(function(i) {
                $(this).unbind().click(function(){
                    $(this).parent().children('li').removeClass(constants.CLASS_NAME_ACTIVE);
                    $(this).addClass(constants.CLASS_NAME_ACTIVE);
                    if($(this).parent().parent().children('.horisontalScroll').children('.item').length){
                        var rightWidth = $(this).parent().parent().width();
                        var leftPosition = rightWidth*i;
                        $(this).parent().parent().children('.horisontalScroll').animate({left:'-'+leftPosition+constants.CSS_PX},500);
                    }
                });
            });
        });
    /* END - Top menu binds */
    
    $(window).resize(function(){
        html.resize(key);
    });
    
    switch(key){
        case constants.GLOBAL_AREA_CABINET:
            /* Top menu logo */
            $(constants.EL_OFFICE_HEAD_LOGO).click(function(){
                $(this).addClass(constants.CLASS_NAME_ACTIVE).children('ul').show();
            });
            $(constants.EL_OFFICE_HEAD_LOGO).mouseleave(function(){
                $(this).removeClass(constants.CLASS_NAME_ACTIVE).children('ul').hide();
            });
            /* END - Top menu logo */
            
            /* Top menu logo binds */
            $(constants.EL_OFFICE_HEAD_LOGO_MENU_ITEM).each(function() {
                $(this).click(function(){
                    if(!$(this).is(constants.EL_OFFICE_HEAD_LOGO_MENU_ITEM_LOGOUT))
                        html.load($(this).attr(constants.ATTR_CLASS), true, false, true);
                    else
                        auth.logout();
                });
            });
            /* END - Top menu logo binds */
            
            /* Right top current office */
            $(constants.EL_OFFICE_HEAD_CURRENT_OFFICE).click(function(){
                $(this).addClass(constants.CLASS_NAME_ACTIVE).children('ul').show();
            });
            $(constants.EL_OFFICE_HEAD_CURRENT_OFFICE).mouseleave(function(){
                $(this).removeClass(constants.CLASS_NAME_ACTIVE).children('ul').hide();
            });
            /* END - Right top current office */
            
            /* Right top menu binds */
            $(constants.EL_OFFICE_HEAD_CURRENT_OFFICE_MENU_ITEM).each(function() {
                $(this).click(function(){
                    html.loadWizard($(this).attr(constants.ATTR_CLASS));
                });
            });
            /* END - Right top menu binds */
        break;
        case constants.GLOBAL_AREA_LOGIN:
            $(constants.EL_LOGIN_FORM_BUT_ENTER).bind(constants.EVENT_CLICK, function(){
                auth.login();
            });
            $(constants.EL_LOGIN_FORM_FORM).keypress(function(){
                if(event.keyCode == 13)
                    auth.login();
            });
        break;
        case constants.PAGE_WIZARD:
            
        break;
    }
}

html.resizeSectionRight = function(){
    var rightWidth = $(constants.EL_OFFICE_PAGE_RIGHT).width();
    var rightHeight = $(constants.EL_OFFICE_PAGE_RIGHT).height();
    var topMenuHeight = $(constants.EL_OFFICE_PAGE_RIGHT_TOP_MENU).outerHeight();
    var horisontalScrollItemLength = $(constants.EL_OFFICE_PAGE_RIGHT_HS_ITEM).length;
    //TODO remove hardcode +100
    var horisontalScrollWidth = rightWidth*horisontalScrollItemLength+100;
    var horisontalScrollHeight = rightHeight-topMenuHeight;
    var verticalScrollHeight = rightHeight*2;
    $(constants.EL_OFFICE_PAGE_RIGHT_VS).css(constants.CSS_HEIGHT,verticalScrollHeight+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_VS).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_VS_ITEM).css(constants.CSS_HEIGHT,rightHeight+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_VS_ITEM).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_HS_ITEM).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_HS).css(constants.CSS_WIDTH,horisontalScrollWidth+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_RIGHT_HS).css(constants.CSS_HEIGHT,horisontalScrollHeight+constants.CSS_PX);
    $(constants.EL_OFFICE_PAGE_MENU_ITEM).each(function(i){
        if($(this).is(constants.CLASS_ACTIVE)){
            var rightHeight = $(constants.EL_OFFICE_PAGE_RIGHT).height();
            var topPosition = rightHeight*i;
            $(constants.EL_OFFICE_PAGE_RIGHT_VS).animate({top:'-'+topPosition+constants.CSS_PX},0);
        }
    });
};