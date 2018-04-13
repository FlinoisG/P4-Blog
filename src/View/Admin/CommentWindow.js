var CommentWindow = function () {}
var CommentWindowOn = false;
CommentWindow.prototype.init = function (message, link, id) {
    if(!CommentWindowOn){
        var Shadow = document.createElement('div');
        Shadow.id = 'Shadow';
        Shadow.className = 'Shadow';
        var Win = document.createElement('div');
        Win.id = 'Win';
        Win.className = 'box CommentWindowWin';
        var signTitle = document.createElement('h3');
        signTitle.id = 'signTitle';
        signTitle.classList = 'signTitle';
        signTitle.textContent = message;
        var BtnAccept = document.createElement('a');
        BtnAccept.id = 'BtnAccept';
        BtnAccept.classList = 'btn btn-outline-danger BtnAccept'
        BtnAccept.textContent = 'Oui';
        BtnAccept.href = link;
        var BtnCancel = document.createElement('a');
        BtnCancel.id = 'BtnCancel';
        BtnCancel.classList = 'btn btn-outline-primary BtnCancel'
        BtnCancel.textContent = 'Annuler';
        Win.appendChild(signTitle);
        Win.appendChild(BtnAccept);
        Win.appendChild(BtnCancel);
        Shadow.append(Win);
        document.body.append(Shadow);
        CommentWindowOn = true;
    }
}

CommentWindow.prototype.remove = function () {
    document.getElementById('Shadow').remove();
    CommentWindowOn = false;
}

var CommentWindow = new CommentWindow();

document.addEventListener('click', function (event) {
    if (event.target.id == 'BtnCancel'){
        CommentWindow.remove();
    }
});