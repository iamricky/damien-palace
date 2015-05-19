jQuery(document).ready(
    function($) {
        $.ajax({
            url: the_api.ajax_url,
            type: "post",
            dataType: "json",
            data: {
                action: "query_photos"
            }
        }).done(function(data) {
            console.log("got photos!");

            $.each(data, function(idx, img) {

                var $elem = $(".photos").find(".row:last"),
                    html = "<div class='photo'>";

                html += "<img src=" + img.large_img + " />",
                html += "</div>";

                $elem.append(html);
            });
        });
    }
);
