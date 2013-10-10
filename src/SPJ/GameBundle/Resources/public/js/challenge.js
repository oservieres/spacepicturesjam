spacePicturesJam.challenge = {};

spacePicturesJam.challenge.init = function() {
    $('.challenge_pictures').each(function() {
        spacePicturesJam.challenge.loadPictures($(this));
    });

    $('.challenge_user_picture').each(function() {
        spacePicturesJam.challenge.loadUserPicture($(this));
    });
}

spacePicturesJam.challenge.loadUserPicture = function(pictureContainer) {
    $.ajax({
        url : pictureContainer.attr('data-content_url'),
        dataType: 'html'
    }).done(function(response) {
        pictureContainer.html(response);
        $('#picture_upload_button').click(spacePicturesJam.challenge.displayUploadForm);
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
