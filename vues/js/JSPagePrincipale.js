$(document).ready(function() {
    var todoListItem = $('.todo-list');

    todoListItem.on('change', '.checkbox', function () {
        var tache = $(this).parents('li').find('label').attr('for');
        var liste = $(this).parents('main').find('h5').html();
        alert(tache);
        alert(liste);
        $.ajax({
            url: "vues/js/update.php",
            type: "POST",
            data: {Liste: liste,Tache: tache}
        })
    });
});

