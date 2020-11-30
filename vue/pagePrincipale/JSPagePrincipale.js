$('#delete').click(function() {
    var url = '../../modeles/gestionTaches/SupprimerTache.php';
    $(this).slideUp();
    $.post(url);
});