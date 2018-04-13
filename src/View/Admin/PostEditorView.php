<?php 
$title = "Blog de Jean Forteroche - Editeur d'article";
$header = '<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ytdbv6007rzv009uec0hsu3v0b57g8mcs0o9l6ik6e4du5iy"></script>
<script>
    tinymce.init({
        
        mode: "exact",
        elements : "elm1",
        selector:\'textarea\',
        width: 871,
        min_height: 500,
    });
</script>';
if($post != null){
    $editorTitle = $post->getTitle();
    $editorContent = $post->getContent();
    $editorAction = '/public/?p=admin.post_submit&params=' . $post->getId();
} else {
    $editorTitle = '';
    $editorContent = '';
    $editorAction = '/public/?p=admin.post_submit';
}
ob_start(); 
?> 
<div class="post-editor">
<form id="editorForm" action="<?= $editorAction ?>" method="post">
    Titre : 
    <input class="editor-username editor-admin" type="text" maxlength="50" name="post-title" value="<?= $editorTitle ?>">
    <br><br>
    Message :<br>
    <textarea class="" name="post-content"><?= $editorContent ?></textarea>
    <a id="PostEditorSubmit" class="btn btn-outline-primary">Envoyer</a>
    <a id="PostEditorCancel" class="btn btn-outline-danger" >Annuler</a>
    <script>
    document.addEventListener('click', function (event) {
        if (event.target.id == 'PostEditorCancel'){
            CommentWindow.init('Êtes-vous sur de vouloir quiter sans sauvegarder les modifications ?', '/public/?p=admin.post');
        }
    });
    document.addEventListener('click', function (event) {
        if (event.target.id == 'PostEditorSubmit'){
            CommentWindow.init('Envoyer l\'article ?', '', true);
        }
    });
</script>
</form> 
</div>
<script src="assets/js/ConfirmWin.js"></script>
<?php 
$content = ob_get_clean();

require(dirname(__DIR__).'/base.php'); ?>