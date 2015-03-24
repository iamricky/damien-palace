<?php get_header(); ?>
<div class="cover">
    <div class="cover-image">
        <div class="masthead">Damien Palace</div>
    </div>
</div>

<?php $partials = array( "partials/news", "partials/music", "partials/videos", "partials/featured", "partials/photos", "partials/events", "partials/munz-mind" );

foreach ( $partials as $partial ) {
    get_template_part( $partial );
}
get_footer(); ?>
