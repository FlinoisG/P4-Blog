<?php 
ob_start();
?> 
<div class="post-editor box">
<form id="editorForm" action="<?= $editorAction ?>" method="post">
    Titre : 
    <input class="editor-username editor-admin" type="text" maxlength="50" name="post-title" value="<?= $editorTitle ?>">
    <br><br>
    Message :<br>
    <textarea class="" name="post-content"><?= $editorContent ?></textarea>
    <a id="PostEditorSubmit" class="btn btn-outline-primary">Envoyer</a>
    <a id="PostEditorCancel" class="btn btn-outline-danger" >Annuler</a>
</form> 
</div>
<script src="assets/js/EditorButtons.js"></script>
<script src="assets/js/ConfirmWin.js"></script>
<?php 
$content = ob_get_clean();
require(dirname(__DIR__).'/base.php');
