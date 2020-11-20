$('#delete').click(function() {
    var url = '../../Modele/GestionTaches/supprimer.php';
    $(this).slideUp();
    $.post(url);
});