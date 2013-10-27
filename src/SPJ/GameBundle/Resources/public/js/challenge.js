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

    $('.countdown').each(function() {
        $(this).countdown({
            until: new Date($(this).attr('data-end_date')),
            onExpiry: function() { window.location.reload() },
        });
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
            scrolling : 'no',
            padding : 0,
            content : response,
            afterShow : spacePicturesJam.challenge.bindPictureDetails
        });
    });
};

spacePicturesJam.challenge.bindPictureDetails = function() {
    $('.stars a.rating_star').click(function(event) {
        event.preventDefault();
        spacePicturesJam.rating.create($(this).attr('href'), $(this).attr('data-value'));
    });
    var commentForm = $('.fancybox-inner .comments form');
    commentForm.find('.submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            method : 'post',
            url : commentForm.attr('action'),
            data : commentForm.serialize(),
            dataType: 'json'
        }).done(function(response) {
            $(".comments ul.list-group").animate({
                scrollTop: $(".comments ul.list-group")[0].scrollHeight
            }, 300);
            var commentContainer = $('<li class="list-group-item"></li>');
            commentContainer.append($('<span class="author"></span>').html(response.data.comment.username));
            commentContainer.append($('<span class="content"></span>').html(response.data.comment.content));
            var dateContainer = $('<span></span>').html(response.data.comment.date_created);
            commentContainer.append($('<p class="date"></p>').append(dateContainer));
            $('.fancybox-inner .comments ul').append(commentContainer);
        });
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
