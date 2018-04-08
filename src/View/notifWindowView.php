
<p id="flagwin" class="flag-window box" style="color: <?= $notifWindowColor ?>; border-color: <?= $notifWindowColor ?>;"><?= $notifWindowContent ?></p>

<script>
setTimeout(function () {
    var elem = document.getElementById("flagwin")
    elem.style.animationName = "fade"; 
    elem.style.animationDuration = "1s"; 
    elem.style.animationTimingFunction = "ease";
}, 3000)
</script>