jQuery(document).ready(function($) {

    var initPhotos = $.ajax({
        url: the_api.ajax_url,
        type: "post",
        dataType: "json",
        data: {
            action: "query_photos"
        }
    });

    initPhotos.done(function(data) {
        console.log("got photos!");

        $.each(data, function(index, obj) {

            var $elem = $(".photos").find(".row:last"),
                output = "<div class='photo'>";

                output += "<img class='img-sm' src=" + obj.small_img + " />",
                output += "<img class='img-lg' src=" + obj.large_img + " />",
                output += "</div>";

            $elem.append(output);
        });
    });
});
