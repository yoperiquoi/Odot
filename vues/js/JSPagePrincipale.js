(function($) {
    'use strict';
    $(function() {
        var todoListItem = $('.todo-list');

        todoListItem.on('change', '.checkbox', function() {
            if ($(this).attr('checked')) {
                $(this).removeAttr('checked');
            } else {
                $(this).attr('checked', 'checked');
            }
            var tache = $(this).closest("label").text();
            var liste = $(this).closest("h5").text();
        });
    });
})(jQuery);
