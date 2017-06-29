function errorHighlight(e, type, icon) {
    if (!icon) {
        if (type === 'highlight') {
            icon = '../style/succ.png';
        } else if( type === 'errorPage') {
            icon = '../style/error.png';
        }else if( type === 'error') {
            icon = '../style/error.png';
        } else if( type === 'info')  {
            icon = '../style/info.jpg';
        } else if( type === 'warnings')  {
            icon = '../style/warnings.png';
        }
    }
    return e.each(function () {
        $(this).addClass('ui-widget');
        var h = '<p>';
        h += '<img src="' + icon + '" style="float:left;margin-right: .5em;margin-left: .3em;width: 15px;vertical-align: bottom;">';
        h += $(this).html();
        h += '</p>';

        $(this).html(h);
    });
}

//error box
(function ($) {
    $.fn.error = function () {
        errorHighlight(this, 'error');
    };
})(jQuery);

//highlight (alert) box
(function ($) {
    $.fn.highlight = function () {
        errorHighlight(this, 'highlight');
    };
})(jQuery);

//Info box
(function ($) {
    $.fn.info = function () {
        errorHighlight(this, 'info');
    };
})(jQuery);

//Warnings box
(function ($) {
    $.fn.warnings = function () {
        errorHighlight(this, 'warnings');
    };
})(jQuery);

//errorPage box
(function ($) {
    $.fn.errorPage = function () {
        errorHighlight(this, 'errorPage');
    };
})(jQuery);

$(document).ready(function () {
    $('.error').error();
    $('.succ').highlight();
    $('.errorPage').errorPage();
    $('.info').info();
    $('.warnings').warnings();
});