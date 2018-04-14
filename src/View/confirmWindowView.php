<div id="confirmwin" class="confirm-window box" style="color: <?= $confirmWindowColor ?>; border-color: <?= $confirmWindowColor ?>;">
    <p><?= $confirmWindowContent ?></p>
    <a class="btn btn-danger btn-admin"  href="">Oui</a>
    <a class="btn btn-danger btn-admin"  href="?p=admin.post&delete=<?= $post->getId() ?>">Non</a>
</div>

<script>
setTimeout(function () {
    var elem = document.getElementById("flagwin")
    elem.style.animationName = "fade"; 
    elem.style.animationDuration = "1s"; 
    elem.style.animationTimingFunction = "ease";
}, 3000)
</script>