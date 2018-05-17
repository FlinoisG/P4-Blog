
var ContentShort = {};
var ContentExpanded = {};    
for (i = 0; i < commentId.length; i++){
    commentContent[i] = commentContent[i].replace(new RegExp('&amp;quot;', 'g'), '"');
    commentContentShort[i] = commentContentShort[i].replace(new RegExp('&amp;quot;', 'g'), '"');
    commentContentExpanded[i] = commentContentExpanded[i].replace(new RegExp('&amp;quot;', 'g'), '"');
    var n = commentId[i];
    ContentShort[n] = commentContent[i].substr(0, 170) + '... <span class="adminExpand short" id="adminExpand' + n + '">lire la suite</span>' ;
    ContentExpanded[n] = commentContent[i] + "<span class=\"adminExpand expanded\" id=\"adminExpand" + n + "\"> Lire moins</span>";
}
document.addEventListener('click', function (event) {
    if (event.target.id.includes('SupprBtn')){
        var btnId = event.target.id.replace('SupprBtn','');
        var btnArticleId = event.target.className.replace('btn btn-danger btn-admin-com article','');
        CommentWindow.init('Confirmer la suppression du commentaire', '?p=admin.comments&id=' + btnArticleId + '&delete=' + btnId);
    }                          
    if (event.target.id.includes('adminExpand')){   
        var btnId = event.target.id.replace('adminExpand','');                         
        if (event.target.className.includes('expanded')){
            document.getElementById('content' + btnId).innerHTML = ContentShort[btnId];
        } else if (event.target.className.includes('short')) {
            document.getElementById('content' + btnId).innerHTML = ContentExpanded[btnId];
        }
    }
});
