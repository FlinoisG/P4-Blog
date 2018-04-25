document.addEventListener('click', function (event) {
    if (event.target.id == 'PostEditorCancel'){
        CommentWindow.init('Êtes-vous sur de vouloir quiter sans sauvegarder les modifications ?', '?p=admin.post');
    }
});
document.addEventListener('click', function (event) {
    if (event.target.id == 'PostEditorSubmit'){
        CommentWindow.init('Envoyer l\'article ?', '', true);
    }
});