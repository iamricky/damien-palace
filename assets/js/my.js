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
            return $(className).find(".media");
        },
        fetchPartial = function(partialName) {
            var dir = wp_urls.template_url + "/assets/js/partials/",
                partial = dir + partialName;

            return partial;
        },
        setupView = function(obj) {

            var $view = obj.view,
                $viewParent = $view.parent(),
                btnExists = $viewParent.find(".paginate-btn").length,
                btn = "<div class=\"paginate-btn\"><div>View More</div></div>";

            var media = obj.data,
                part = obj.partial,
                sliceEnd = media.length > 8 ? 8 : media.length;

            $.get(fetchPartial(part), function(template) {

                if (media.length > 8 && !btnExists) {
                    $viewParent.append(btn);
                }

                $.each(media.slice(0, sliceEnd), function(idx, obj) {

                    var rendered = Mustache.render(template, obj);

                    $view.append(rendered);
                    media.shift(0, 1);

                    if (~part.indexOf("featured")) {
                        return false;
                    }
                });
            });
        };

    var data = {},
        view = {
            photo: fetchView(".photos"),
            video: {
                featured: fetchView(".featured"),
                official: fetchView(".videos"),
                munzmind: fetchView(".munz-mind")
            }
        },
        setupParams;

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
            partial: "featured.mst",
            view: view.video.featured,
            data: data.video.featured
        }, {
            partial: "official.mst",
            view: view.video.official,
            data: data.video.official
        }, {
            partial: "munzmind.mst",
            view: view.video.munzmind,
            data: data.video.munzmind
        }];

        $.each(setupParams, function(idx, params) {
            setupView(params);
        });
    });

    $.fn.pagination = function() {

        $(document).on("click", ".paginate-btn", function() {

            $parents = $(this).parents();

            if ($parents.hasClass("photos")) {
                if (data.photo.length > 0) {
                    setupView(setupParams[0]);
                } else {
                    fetchMedia("pagination").then(function(more) {
                        setupParams[0].data = data.photo = more;
                        setupView(setupParams[0]);
                    });
                }
            } else {

            }
        });
    };

    $(".paginate-btn").pagination();
});

jQuery(function($) {

    // fancybox
    $(".fancybox").fancybox({
        helpers: {
            media: {
                youtube: {
                    params: {
                        autoplay: 1,
                        controls: 0,
                        showinfo: 0
                    }
                }
            }
        },
        padding: 0
    });

    // fitText
    $(".cover").find(".cover-image > .masthead").fitText();
});
