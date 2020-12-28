$(document).ready(function() {
    var todoListItem = $('.todo-list');
    todoListItem.on('change', '.checkbox', function () {
        var tache = $(this).parents('li').find('label').attr('for');
        var liste = $(this).parents('main').find('h5').html();
        var id= $(this).parents('li').find('form').find('input').val();
        $.ajax({
            url: "index.php",
            method: "GET",
            data: {action:"cocheTachePrivee",Liste: liste,Tache: tache,Id: id},
        })
    });
});

