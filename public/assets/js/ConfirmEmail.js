var email = document.getElementById("email");

//function validateEmail() {
//  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//  return re.test(String(email).toLowerCase());
//  email.setCustomValidity('');
//}



//var booking_email = $('input[name=booking_email]').val();

function validateEmail() {
  if( /(.+)@(.+){2,}\.(.+){2,}/.test(email) ){
    email.setCustomValidity('caca');
  } else {
    email.setCustomValidity('');
  }
}




email.onchange = validateEmail;
email.onkeyup = validateEmail;