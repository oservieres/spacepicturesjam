spacePicturesJam.rating = {};

spacePicturesJam.rating.create = function(url, value) {
    $.ajax({
        method : 'post',
        url : url,
        data : 'value=' + value,
        dataType: 'json'
    }).done(function(response) {
        alert("Thank you !");
    });
}
