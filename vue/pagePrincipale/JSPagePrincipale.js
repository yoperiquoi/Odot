$('#delete').click(function() {
    var url = '../../modele/gestionTaches/SupprimerTache.php';
    $(this).slideUp();
    $.post(url);
});