<?php get_header(); ?>
<div class="cover">
    <div class="cover-image">
        <div class="masthead">Damien Palace</div>
    </div>
</div>

<?php

$dir = "partials";
$partials = array( "${dir}/news", "${dir}/music", "${dir}/videos", "${dir}/featured", "${dir}/photos", "${dir}/events", "${dir}/munz-mind" );

foreach ( $partials as $partial ) {
    get_template_part( $partial );
}
get_footer(); ?>
