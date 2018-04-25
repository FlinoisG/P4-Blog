var content = document.getElementById('title').textContent;
var menu = document.getElementById('menu');
var footer = document.getElementById('footer');
function myFunction(x) {
    if (x.matches) {        
        if (menu != null){
        footer.appendChild(
            document.getElementById('admin-link')
        );
    }
        document.getElementById('title').textContent = "Blog de Jean Forteroche";
    } else {
        if (menu != null){
        menu.appendChild(
            document.getElementById('admin-link')
        );
    }
        document.getElementById('title').textContent = content;
    }
}
var x = window.matchMedia("(max-width: 1000px)")
myFunction(x)
x.addListener(myFunction)