spacePicturesJam.rating = {};

spacePicturesJam.rating.create = function(url, value) {
    $.ajax({
        method : 'post',
        url : url,
        data : 'value=' + value,
        dataType: 'json'
    }).done(function(response) {
        $('.rating_star').each(function() {
            if (response.data.rating.value >= $(this).attr('data-value')) {
                $(this).addClass('highlighted');
            } else {
                $(this).removeClass('highlighted');
            }
        });
    });
}
