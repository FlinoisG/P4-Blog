document.addEventListener('click', function (event) {
    if (event.target.id.includes('SupprBtn')){
        var btnId = event.target.id.replace('SupprBtn','');
        CommentWindow.init('Confirmer la suppression de l\'article', '?p=admin.post&delete=' + btnId);
    }
});
