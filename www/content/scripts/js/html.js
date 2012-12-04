/**
 * Javascript class for Web Office
 * binder for pages
 * Created by Mihael Isaev
 */

$.include('/content/scripts/js/jquery-ui-1.8.17.custom.min.js');
$.include('/content/scripts/js/visual.js');
$.include('/content/scripts/js/ajax.js');
$.include('/content/scripts/js/helper.js');

html = {}

/**
 * Load main area
 */
html.loadArea = function(area){
    system.log('load area: '+area);
    ajax.run({
        data: ({module: constants.MODULE_HTML_GLOBAL_AREA, action:area}),
        showProgressBar: true,
        fast:true,
        onSuccess: function(data){
            html.setAreaData(data);
            html.afterLoadArea(area);
            system.log('finish load area: '+area);
        }
    });
}

html.setAreaData = function(data){
    $(constants.EL_MAIN_DATA).html(data);
    system.log('set area data');
}

html.afterLoadArea = function(area){
    system.log('afterloadarea: '+area);
    html.bind(area);
    switch(area){
        case constants.GLOBAL_AREA_LOGIN:
            $(constants.EL_LOGIN_FORM).animate({top: 0}, 1000);
            setTimeout(function(){$(constants.EL_LOGIN_FORM_FORM_LOGIN).slideDown();}, 1200);
        break;
        case constants.GLOBAL_AREA_CABINET:
            $(constants.EL_HEAD).animate({top: 0}, 1000, function(){
                $(constants.EL_HEAD_USER).fadeIn(constants.SPEED_SLOW);
                $(constants.EL_PAGES).fadeIn(constants.SPEED_SLOW);
                $(constants.EL_FOOTER).fadeIn(constants.SPEED_SLOW);
            });
            var firstItemInMenu = $(constants.EL_HEAD_LOGO_MENU_ITEM).first().attr(constants.ATTR_CLASS);
            html.load(firstItemInMenu, false, true);
            html.resize();
            system.log('finish afterloadarea: '+area);
        break;
    }
}

html.showRegistration = function(){
    $(constants.EL_LOGIN_FORM_FORM_LOGIN).slideUp(function(){
        $(constants.EL_LOGIN_FORM_FORM_REGISTRATION).slideDown();
    });
}

html.showLogin = function(){
    $(constants.EL_LOGIN_FORM_FORM_REGISTRATION).slideUp(function(){
        $(constants.EL_LOGIN_FORM_FORM_LOGIN).slideDown();
    });
}

html.load = function(page, showProgressBar, fast) {
    if(system.currentPage !== page && !$('.pages .'+page).length)
        ajax.run({
            data: ({module: constants.MODULE_HTML_AREA, action: page}),
            fast: fast,
            showProgressBar: showProgressBar,
            onSuccess: function(data){
                html.appendPage(page, data, fast);
                html.resize();
                if($(constants.EL_PAGE).length){
                    html.resizePage(page);
                    html.bind(constants.PAGE_RIGHT);
                }
                html.bind(page);
                system.currentPage = page;
            }
        });
    else if(system.currentPage !== page && $('.pages .'+page).length)
        html.showPage(page, fast);
}

html.appendPage = function(page, data, fast){
    system.log('appendPage '+page+' has called');
    $('.pages').append('<div class="page '+page+'">'+data+'</div>');
    $('.page').fadeOut('slow',function(){
        if(fast)
            $('.'+page).fadeIn();
        else
            setTimeout(function(){$('.'+page).fadeIn();}, 1000);
    });
}

html.showPage = function(page, fast){
    system.log('showPage '+page+' has called');
    $('.page').fadeOut('slow',function(){
        if(fast)
            $('.'+page).fadeIn();
        else
            setTimeout(function(){$('.'+page).fadeIn();}, 1000);
    });
}

html.bind = function(key){
    html.bindGlobal();
    switch(key){
        case constants.GLOBAL_AREA_CABINET:
            html.bindCabinet();
        break;
        case constants.GLOBAL_AREA_LOGIN:
            html.bindLogin();
        break;
        case constants.PAGE_WIZARD:
            
        break;
    }
}

html.bindGlobal = function(){
    /* Left menu items bind */
    if($(constants.EL_PAGE_MENU).length)
        $(constants.EL_PAGE_MENU_ITEM).each(function(i) {
            $(this).unbind().click(function(){
                $(constants.EL_PAGE_MENU_ITEM).removeClass(constants.CLASS_NAME_ACTIVE);
                $(this).addClass(constants.CLASS_NAME_ACTIVE);
                if($(constants.EL_PAGE_RIGHT_VS).length){
                    var rightHeight = $(constants.EL_PAGE_RIGHT).height();
                    var topPosition = rightHeight*i;
                    $(constants.EL_PAGE_RIGHT_VS).animate({top:'-'+topPosition+constants.CSS_PX},500);
                }
            });
        });
    if($(constants.EL_PAGE_RIGHT_VS).length)
        $(constants.EL_PAGE_RIGHT_VS_ITEM).each(function(i) {
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
    
    $(window).resize(function(){html.resize();});
}

html.bindCabinet = function(){
    /* Top menu logo */
    $(constants.EL_HEAD_LOGO).click(function(){
        $(this).addClass(constants.CLASS_NAME_ACTIVE).children('ul').show();
    });
    $(constants.EL_HEAD_LOGO).mouseleave(function(){
        $(this).removeClass(constants.CLASS_NAME_ACTIVE).children('ul').hide();
    });
    /* END - Top menu logo */

    /* Top menu logo binds */
    $(constants.EL_HEAD_LOGO_MENU_ITEM).each(function() {
        $(this).click(function(){
            if(!$(this).is(constants.EL_HEAD_LOGO_MENU_ITEM_LOGOUT))
                html.load($(this).attr(constants.ATTR_CLASS), true, false, true);
            else
                auth.logout();
        });
    });
    /* END - Top menu logo binds */

    /* Right top current office */
    $(constants.EL_HEAD_CURRENT_OFFICE).click(function(){
        $(this).addClass(constants.CLASS_NAME_ACTIVE).children('ul').show();
    });
    $(constants.EL_HEAD_CURRENT_OFFICE).mouseleave(function(){
        $(this).removeClass(constants.CLASS_NAME_ACTIVE).children('ul').hide();
    });
    /* END - Right top current office */

    /* Right top menu binds */
    $(constants.EL_HEAD_CURRENT_MENU_ITEM).each(function() {
        $(this).click(function(){
            html.loadWizard($(this).attr(constants.ATTR_CLASS));
        });
    });
    /* END - Right top menu binds */
    
    $(window).resize(function(){
        html.resize();
    });
}

html.bindLogin = function(){
    $(constants.EL_LOGIN_FORM_BUT_REGISTRATION).bind(constants.EVENT_CLICK, function(){html.showRegistration();});
    $(constants.EL_LOGIN_FORM_BUT_ENTER).bind(constants.EVENT_CLICK, function(){auth.login();});
    $(constants.EL_REGISTER_FORM_BUT_CANCEL).bind(constants.EVENT_CLICK, function(){html.showLogin();});
    $(constants.EL_REGISTER_FORM_BUT_REGISTER).bind(constants.EVENT_CLICK, function(){auth.register();});
    $(constants.EL_LOGIN_FORM_FORM_LOGIN).keypress(function(){
        if(event.keyCode == 13)
            auth.login();
    });
    $(constants.EL_LOGIN_FORM_FORM_REGISTRATION).keypress(function(){
        if(event.keyCode == 13)
            auth.register();
    });
    if($(constants.EL_REGISTER_FORM_CAPTCHA_IMAGE).length)
        $(constants.EL_REGISTER_FORM_CAPTCHA_IMAGE).click(function(){
            $(this).attr('src', '/content/scripts/php/captcha/?area=register&random='+helper.getRandomInt(0,1000));
        });
}


html.loadWizard = function(page) {
    ajax.run({
        data: ({module: constants.MODULE_HTML_WIZARD, action: page}),
        showProgressBar: true,
        beforeSend: function(){
            $(constants.EL_PAGE).fadeOut(constants.SPEED_SLOW).html('');
        },
        onSuccess: function(data){
            $(constants.EL_PAGE).html(data).fadeIn(constants.SPEED_SLOW);
            html.resize();
            html.bind(constants.PAGE_WIZARD);
        }
    });
}

html.resize = function(){
    $(constants.EL_PAGE_MENU_ITEM).each(function(i){
        var page = $(this).attr('class');
        html.resizePage(page);
    });
}

html.resizePage = function(page){
        //Высота окна
        var windowHeight = $(window).height();
        system.logA('windowHeight = '+windowHeight);
        //Высота .header
        var headHeight = $(constants.EL_HEAD).outerHeight();
        //Высота .footer
        var footerHeight = $('.footer').outerHeight();
        //Высота .pages
        var pagesHeight = windowHeight - footerHeight - headHeight - 50;
        $(constants.EL_PAGES).css(constants.CSS_HEIGHT, pagesHeight+constants.CSS_PX);
        system.logA('pagesHeight = '+pagesHeight);
        //Высота .page
        $('.pages.'+page).css('height',pagesHeight+'px');
        var pageHeight = pagesHeight;
        system.logA('pageHeight = '+pageHeight);
        //Высота .right
        $('.'+page+' '+constants.EL_PAGE_RIGHT).css('height',pageHeight);
        var rightHeight = $('.'+page+' '+constants.EL_PAGE_RIGHT).height();
        //Высота .topMenu
        var topMenuHeight = $('.'+page+' '+constants.EL_PAGE_RIGHT_TOP_MENU).outerHeight();
        //Высота .verticalScroll
        var verticalScrollHeight = rightHeight*$('.'+page+' '+constants.EL_PAGE_MENU_ITEM).length;
        //Высота .horisontalScroll
        var horisontalScrollHeight = rightHeight-topMenuHeight;
        
        //Ширина окна
        var windowWidth = $(window).width();
        
        //Ширина .right
        var newRightWidth = windowWidth-400;
        $('.'+page+' '+constants.EL_PAGE_RIGHT).css('width',newRightWidth+'px');
        
        var rightWidth = $('.'+page+' '+constants.EL_PAGE_RIGHT).width();
        
        
        var horisontalScrollItemLength = $('.'+page+' '+constants.EL_PAGE_RIGHT_HS_ITEM).length;
        //TODO remove hardcode +100
        var horisontalScrollWidth = rightWidth*horisontalScrollItemLength+100;
        
        
        $('.'+page+' '+constants.EL_PAGE_RIGHT_VS).css(constants.CSS_HEIGHT,verticalScrollHeight+constants.CSS_PX);
        system.logA('right height = '+rightHeight);
        system.logA('VS height = '+verticalScrollHeight);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_VS).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_VS_ITEM).css(constants.CSS_HEIGHT,rightHeight+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_VS_ITEM).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_HS_ITEM).css(constants.CSS_WIDTH,rightWidth+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_HS).css(constants.CSS_WIDTH,horisontalScrollWidth+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_RIGHT_HS).css(constants.CSS_HEIGHT,horisontalScrollHeight+constants.CSS_PX);
        $('.'+page+' '+constants.EL_PAGE_MENU_ITEM).each(function(i){
            if($(this).is(constants.CLASS_ACTIVE)){
                var rightHeight = $(constants.EL_PAGE_RIGHT).height();
                var topPosition = rightHeight*i;
                $('.'+page+' '+constants.EL_PAGE_RIGHT_VS).animate({top:'-'+topPosition+constants.CSS_PX},0);
            }
        });
        system.log('resize right finish');
};

html.formInputColorAndError = function(data, elementInput, elementInfo){
    if(data == '')
        $(elementInput).css(constants.CSS_BACKGROUND, constants.COLOR_WHITE);
    else
        $(elementInput).css(constants.CSS_BACKGROUND, constants.COLOR_LIGHT_PINK);
    $(elementInfo).html(data);
}