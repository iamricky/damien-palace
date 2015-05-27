<?php get_header(); ?>

<div class="cover">
    <div class="cover-image">
        <div class="masthead">Damien Palace</div>
    </div>
</div>

<?php

$dir = "partials/";
$partials = array( "news", "music", "videos", "featured", "photos", "events", "munz-mind" );

foreach ( $partials as $partial ) {
    get_template_part( $dir .  $partial );
} ?>

<?php get_footer(); ?>
