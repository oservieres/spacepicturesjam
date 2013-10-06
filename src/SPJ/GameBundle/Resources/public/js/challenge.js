spacePicturesJam.challenge = {};

spacePicturesJam.challenge.init = function() {
    $('#picture_upload_button').click(spacePicturesJam.challenge.displayUploadForm);

    spacePicturesJam.challenge.loadPictures();
}

spacePicturesJam.challenge.loadPictures = function() {
    $('.challenge_pictures').each(function() {
        var picturesContainer = $(this);
        $.ajax({
            url : picturesContainer.attr('data-pictures_url'),
            dataType: 'html'
        }).done(function(response) {
            picturesContainer.html(response);
        });
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

spacePicturesJam.challenge.init();
