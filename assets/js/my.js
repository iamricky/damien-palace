jQuery(function($) {

    var fetchMedia = function(media) {
            return $.ajax({
                dataType: "json",
                data: {
                    action: "query_" + media
                },
                type: "post",
                url: the_api.ajax_url
            });
        },
        requests = [
            fetchMedia("photos"),
            fetchMedia("videos")
        ];

    $.when.apply($, requests).then(function(photos, videos) {});
});
