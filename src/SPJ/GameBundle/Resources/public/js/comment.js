spacePicturesJam.comment = {};

spacePicturesJam.comment.lockForm = function(commentForm) {
    if ('true' == commentForm.attr('is_locked')) {
        return false;
    }
    commentForm.attr('is_locked', 'true');
    return true
};

spacePicturesJam.comment.unlockForm = function(commentForm) {
    commentForm.attr('is_locked', 'false');
};
spacePicturesJam.comment.initForm = function(commentForm) {
    var challengeId = commentForm.attr('data-challenge_id');
    commentForm.find('.content').keypress(function(e) {
        if (13 != e.which) {
            return;
        }
        if (!spacePicturesJam.comment.lockForm(commentForm)) {
            return;
        }
        e.preventDefault();
        $.ajax({
            method : 'post',
            url : commentForm.attr('action'),
            data : commentForm.serialize(),
            dataType: 'json'
        }).done(function(response) {
            commentForm.find('.content').val('');
            spacePicturesJam.comment.unlockForm(commentForm)
            $("#challenge_" + challengeId + "_comments ul.list-group").animate({
                scrollTop: $("#challenge_" + challengeId + "_comments ul.list-group")[0].scrollHeight
            }, 300);
            var commentContainer = $('<li class="list-group-item"></li>');
            commentContainer.append($('<span class="author"></span>').html(response.data.comment.username));
            commentContainer.append($('<span class="content"></span>').html(response.data.comment.content));
            var dateContainer = $('<span></span>').html(response.data.comment.date_created);
            commentContainer.append($('<p class="date"></p>').append(dateContainer));
            $("#challenge_" + challengeId + "_comments ul").append(commentContainer);
        });
    });
}
