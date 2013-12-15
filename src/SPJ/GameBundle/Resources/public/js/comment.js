spacePicturesJam.comment = {};

spacePicturesJam.comment.initForm = function(commentForm) {
    var challengeId = commentForm.attr('data-challenge_id');
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
            $("#challenge_" + challengeId + "_comments ul.list-group").animate({
                scrollTop: $("#challenge_" + challengeId + "_comments ul.list-group")[0].scrollHeight
            }, 300);
            var commentContainer = $('<li class="list-group-item"></li>');
            commentContainer.append($('<span class="author"></span>').html(response.data.comment.username));
            commentContainer.append($('<span class="content"></span>').html(response.data.comment.content));
            var dateContainer = $('<span></span>').html(response.data.comment.date_created);
            commentContainer.append($('<p class="date"></p>').append(dateContainer));
            $("#challenge_" + challengeId + "_comments ul").append(commentContainer);
            commentForm.find('.content').val('');
        });
    });
}
