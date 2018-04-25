

var CommentContentExpend = function  (id, articleId, $contentExpanded, $contentShort) {
    var expanded = false;
    var val = id;
    document.addEventListener('click', function (event) {
        if (event.target.id == 'SupprBtn' + id){
            CommentWindow.init('Confirmer la suppression du commentaire', '?p=admin.comments&id=' + articleId + '&delete=' + id);
        }
        if (event.target.id == 'adminExpand' + id){                            
            if (expanded){
                document.getElementById('content' + id).innerHTML = $contentExpanded;
                expanded = false;
            } else {
                document.getElementById('content' + id).innerHTML = $contentShort;
                expanded = true;
            }
        }
    });
}

