spacePicturesJam.challenge = {};

spacePicturesJam.challenge.displayUploadForm = function(event) {
    event.preventDefault();
    $.fancybox.open({
        padding : 0,
        href: $('#picture_upload_button').attr('data-href'),
        type: 'iframe'
    });
}

$('#picture_upload_button').click(spacePicturesJam.challenge.displayUploadForm);
