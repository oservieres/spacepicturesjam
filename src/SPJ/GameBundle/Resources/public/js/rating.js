spacePicturesJam.rating = {};

spacePicturesJam.rating.create = function(url, value) {
    $.ajax({
        method : 'post',
        url : url,
        data : 'value=' + value,
        dataType: 'json'
    }).done(function(response) {
        if (201 != response.code) {
            return;
        }
        $('.rating_summary .average .badge').html(response.data.rating.new_average);
        $('.rating_summary .count .badge').html(response.data.rating.new_count);
        $('.rating_star').each(function() {
            if (response.data.rating.value >= $(this).attr('data-value')) {
                $(this).addClass('highlighted');
            } else {
                $(this).removeClass('highlighted');
            }
        });
    });
}
