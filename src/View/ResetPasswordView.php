<?php ob_start(); ?>
<div class="col-lg-12">
    <form action="?p=admin.newPassword&user=<?= $user ?>" method="post">
        <div class="form-group">
            <label for="loginUsername">Nouveau mot de passe</label>
            <input class="form-control login-form" type="password" id="password" name="password" placeholder="Nouveau mot de passe">
        </div>
        <div class="form-group">
            <label for="loginPassword">Confirmation</label>
            <input class="form-control login-form" type="password" id="confirm_password" name="confirmation" placeholder="Confirmation">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
<script src="assets/js/ConfirmPasswordReset.js"></script>
<?php 
$content = ob_get_clean();
require('base.php');