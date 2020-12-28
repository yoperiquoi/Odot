$(document).ready(function() {
    var todoListItem = $('.todo-list');

    todoListItem.on('change', '.checkbox', function () {
        var tache = $(this).closest("h5");
        var liste = document.getElementById("Liste").innerText;
        alert(tache);
        alert(liste);
        $.ajax({
            url: "vues/js/update.php",
            type: "POST",
            data: {Liste: liste,Tache: tache}
        })
    });
});

