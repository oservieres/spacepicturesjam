spacePicturesJam.picture = {};

spacePicturesJam.picture.displayDetails = function(url) {
    $.ajax({
        url : url,
        dataType: 'html'
    }).done(function(response) {
        $.fancybox.open({
            scrolling : 'no',
            padding : 0,
            content : response,
            afterShow : spacePicturesJam.picture.bindDetailsActions
        });
    });
};

spacePicturesJam.picture.bindDetailsActions = function() {
    $('.stars a.rating_star').click(function(event) {
        event.preventDefault();
        spacePicturesJam.rating.create($(this).attr('href'), $(this).attr('data-value'));
    });
    $('.pager .btn').click(function(event) {
        event.preventDefault();
        $.ajax({
            method : 'get',
            url : $(this).attr('data-href'),
        }).done(function(response) {
            $('.fancybox-inner .picture_details').html(response);
            spacePicturesJam.picture.bindDetailsActions();
        });
    });
    var commentForm = $('.fancybox-inner .comments form');
    commentForm.find('.content').keypress(function(e) {
        if (13 != e.which) {
            return;
        }
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
            commentForm.find('.content').val('');
        });
    });
}


