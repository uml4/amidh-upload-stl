jQuery(function($) {
    $('.bookly-js-cancellation-confirmation-no').off().on('click', function (e) {
        e.preventDefault();
        var $container = $(this).closest('.bookly-js-cancellation-confirmation');
        $('.bookly-js-cancellation-confirmation-buttons', $container).hide();
        $('.bookly-js-cancellation-confirmation-message', $container).show('slow');
    });
});