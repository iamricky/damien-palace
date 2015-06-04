jQuery(function($) {

    var fetchMedia = function(media) {
            return $.ajax({
                dataType: "json",
                data: {
                    action: "query_" + media
                },
                type: "post",
                url: wp_urls.ajax_url
            });
        },
        fetchView = function(className) {
            return $(className).find(".row:last");
        },
        fetchPartial = function(partialName) {
            var dir = wp_urls.template_url + "/assets/js/partials/",
                partial = dir + partialName;

            return partial;
        },
        setupView = function(partial, view, data) {
            $.get(fetchPartial(partial), function(template) {

                var $view = view,
                    videos = data;

                $.each(videos, function(idx, obj) {

                    var rendered = Mustache.render(template, obj);

                    if (idx < 8) {
                        $view.append(rendered);
                    } else {
                        return false
                    }
                });
            });

        }

    var data = {},
        view = {
            photo: fetchView(".photos"),
            video: {
                official: fetchView(".videos"),
                munzmind: fetchView(".munz-mind")
            }
        }

    var requests = [
        fetchMedia("photos"),
        fetchMedia("videos")
    ];

    $.when.apply($, requests).then(function(photos, videos) {

        data = {
            photo: photos[0],
            video: videos[0]
        },
        setupParams = [{
            partial: "photos.mst",
            view: view.photo,
            data: data.photo
        }, {
            partial: "official.mst",
            view: view.video.official,
            data: data.video.official
        }, {
            partial: "munzmind.mst",
            view: view.video.munzmind,
            data: data.video.munzmind
        }]

        $.each(setupParams, function(idx, obj) {
            setupView(obj.partial, obj.view, obj.data);
        });
    });
});
