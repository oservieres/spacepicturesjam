spacePicturesJam.challenge = {};

spacePicturesJam.challenge.init = function() {
    $('.challenge_pictures').each(function() {
        spacePicturesJam.challenge.loadPictures($(this));
    });

    spacePicturesJam.challenge.loadInprogressChallengeUserTab();
}

spacePicturesJam.challenge.loadInprogressChallengeUserTab = function() {
    var tabContainer = $('#inprogress_challenge_user_tab');
    $.ajax({
        url : tabContainer.attr('data-content_url'),
        dataType: 'html'
    }).done(function(response) {
        tabContainer.html(response);
        $('#picture_upload_button').click(spacePicturesJam.challenge.displayUploadForm);
        $('#signup_button').click(function() { window.location = $(this).attr('data-href') });
    });
};

spacePicturesJam.challenge.loadPictures = function(picturesContainer) {
    $.ajax({
        url : picturesContainer.attr('data-content_url'),
        dataType: 'html'
    }).done(function(response) {
        picturesContainer.html(response);
    });
};

spacePicturesJam.challenge.displayUploadForm = function(event) {
    event.preventDefault();
    $.fancybox.open({
        padding : 0,
        href: $('#picture_upload_button').attr('data-href'),
        type: 'iframe'
    });
}

spacePicturesJam.challenge.pictureCreatedCallback = function() {
    spacePicturesJam.challenge.loadPictures($('.challenge_pictures.inprogress'));
    $.fancybox.close();
}

spacePicturesJam.challenge.init();
