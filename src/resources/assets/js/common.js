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

        var url = '?';
        $.each($('.filter'), function(key, item) {
            url += $(item).attr('name') + '=' + $(item).val() + '&';
        });

        url = url.slice(0, -1);

        $.ajax({
            type: 'get',
            url:  url,
            dataType: 'json',
            success: function(data) {
                $pagination.append(data.pagination);
                $table.append(data.table);
            }
        });
    };

    init();
})(jQuery);