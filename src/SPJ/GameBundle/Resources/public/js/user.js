spacePicturesJam.user = {};

spacePicturesJam.user.signupCheck = function(event) {
    event.preventDefault();
    var form = $('#signup_form form');
    var signupCheckUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url : signupCheckUrl,
        data : form.serialize(),
        dataType : 'json'
    }).done(function(response) {
        window.location = response.data.redirect_url;
    });
}

$('#signup_form #spj_gamebundle_user_submit').click(spacePicturesJam.user.signupCheck);
