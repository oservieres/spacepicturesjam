spacePicturesJam.user = {};

spacePicturesJam.user.signupCheck = function(event) {
    event.preventDefault();
    var signupCheckUrl = $('#signup_form form').attr('action');
    $.ajax({
        url : signupCheckUrl,
        dataType : 'json'
    }).done(function(response) {
        window.location = response.data.redirect_url;
    });
}

$('#signup_form #spj_gamebundle_user_submit').click(spacePicturesJam.user.signupCheck);
