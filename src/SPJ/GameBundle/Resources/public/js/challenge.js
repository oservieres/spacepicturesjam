spacePicturesJam.challenge = {};

spacePicturesJam.challenge.init = function() {
    $('.challenge_pictures').each(function() {
        spacePicturesJam.challenge.loadPictures($(this));
    });

    $('.challenge_user_picture').each(function() {
        spacePicturesJam.challenge.loadUserPicture($(this));
    });

    $('#spj_gamebundle_picture_file').change(function() {
        spacePicturesJam.challenge.previewPicture(this);
    });
};

spacePicturesJam.challenge.previewPicture = function (input) {
    if (input.files && input.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function(e) {
            var imageElement = $('<img/>')
                               .attr('width', '100')
                               .attr('class', 'img-thumbnail')
                               .attr('src', e.target.result);
            $('#picture_preview_area').html(imageElement)
        };
        fileReader.readAsDataURL(input.files[0]);
    }
};

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
        picturesContainer.find('.challenge_picture_link').click(function(event) {
            event.preventDefault();
            spacePicturesJam.challenge.displayPictureDetails($(this).attr('href'));
        });
    });
};

spacePicturesJam.challenge.displayPictureDetails = function(url) {
    $.ajax({
        url : url,
        dataType: 'html'
    }).done(function(response) {
        $.fancybox.open({
            fitToView : false,
            autoSize : false,
            width : 900,
            padding : 0,
            content : response,
            afterShow : spacePicturesJam.challenge.bindPictureDetails
        });
    });
};

spacePicturesJam.challenge.bindPictureDetails = function() {
    $('.fancybox-inner .comments .create .submit').click(function(e) {
        e.preventDefault();
        alert('désolé ça marche pas encore');
    });
}

spacePicturesJam.challenge.displayUploadForm = function(event) {
    event.preventDefault();
    $.fancybox.open({
        fitToView : false,
        autoSize : false,
        width : 600,
        height : 400,
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
