$(document).ready(function() {
    var todoListItem = $('.todo-list');
    todoListItem.on('change', '.checkbox', function () {
        var tache = $(this).parents('li').find('label').attr('for');
        var liste = $(this).parents('main').find('h5').html();
        $.ajax({
            url: "index.php",
            method: "GET",
            data: {action:"cocheTachePublique",Liste: liste,Tache: tache},
        })
    });
});

