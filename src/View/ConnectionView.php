<?php ob_start(); ?>
<div class="col-lg-12">
    <form action="?p=admin.post&login=true" method="post">
        <div class="form-group">
            <label for="loginUsername">Nom du compte</label>
            <input class="form-control login-form" type="text" id="loginUsername" name="username" placeholder="Nom du compte">
        </div>
        <div class="form-group">
            <label for="loginPassword">Mot de passe</label>
            <input class="form-control login-form" type="password" id="loginPassword" name="password" placeholder="Mot de passe">
            <?= $link ?>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
<?php 
$content = ob_get_clean();
require('base.php');
