<?php ob_start(); ?>
<div class="col-lg-12">
    <form action="?p=admin.connection&link=sent" method="post">
        <div class="form-group">
            <label for="loginUsername">Adresse mail</label>
            <input class="form-control login-form" type="email" id="loginEmail" name="email" placeholder="Adresse mail" required>
        </div>
        <button type="submit" class="btn btn-primary">Réinitialiser mon mot de passe</button>
    </form>
    <script src="assets/js/ConfirmPasswordReset.js"></script>
</div>
<?php 
$content = ob_get_clean();
require('base.php');
