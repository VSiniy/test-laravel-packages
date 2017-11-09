(function (logging) {

    /**
     * Initializes namespace
     */
    init = function() {
        $(document).on('change', '.filter', getFiltered);
    };

    getFiltered = function(e) {
        e.preventDefault();

        var $table      = $('#table'),
            $pagination = $('#pagination');

        var uri = '?';
        $.each($('.filter'), function(key, item) {
            uri += $(item).attr('name') + '=' + $(item).val() + '&';
        });

        uri = uri.slice(0, -1);

        window.location.href = document.location.origin + document.location.pathname + uri;
    };

    init();
})(jQuery);