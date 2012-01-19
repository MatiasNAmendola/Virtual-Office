/**
 * Javascript class for Web Office
 * Created by Mihael Isaev
 */


page = {}

var MODULE_HTML = 'html';

/**
 * Loader pages
 * @param page - name of page
 * @param showProgressBar - boolean true/false show progressBar or not
 * @param fast - boolean true/false faster loading or with timeout
 */
page.load = function(page, showProgressBar, fast) {
    ajax.run({
        data: ({
            module: MODULE_HTML,
            action: page
        }),
        fast: fast,
        showProgressBar: showProgressBar,
        beforeSend: function(){
            $('.office .page').fadeOut('slow').html('');
        },
        onSuccess: function(data){
            $('.office .page').html(data).fadeIn('slow');
            binder.page(page);
            html.page(page);
        }
    });
}