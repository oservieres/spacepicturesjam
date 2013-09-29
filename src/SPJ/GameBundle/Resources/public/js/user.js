spacePicturesJam.user = {};

spacePicturesJam.user.signup = function() {
    alert("signup !");
}

$('#signup_form #spj_gamebundle_user_submit').click(function() {
    spacePicturesJam.user.signup();
    return false;
});
