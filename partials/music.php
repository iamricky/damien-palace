<div class="music">
    <div class="container">
        <div class="row">
            <h1>music</h1>
        </div>

        <?php

        $args = array(
            "post_type" => array( "music" ),
            "orderby"   => "date"
        );
        $albums = new WP_Query ( $args );
        $index = 0;

        while ( $albums->have_posts() ) : $albums->the_post(); ?>

        <div class="album">
            <a class="permalink" href="<?php the_field( "outgoing_url" ); ?>" target="_blank">
                <?php the_post_thumbnail( "music-thumb" ); ?>
            </a>
            <?php the_title( "<div class='title'>", "</div>" ); ?>
            <div class="excerpt"><?php the_excerpt(); ?></div>
            <a class="permalink" href="<?php the_field( "outgoing_url" ); ?>" target="_blank">listen</a>
        </div>
        <?php $index++; if ( $index % 3 === 0 ) : ?><div class="clearfix"></div><?php endif; ?>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
