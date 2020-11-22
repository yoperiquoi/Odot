$('#delete').click(function() {
    var url = '../../Modele/GestionTaches/SupprimerTache.php';
    $(this).slideUp();
    $.post(url);
});