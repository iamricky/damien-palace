<div class="events">
    <div class="container">
        <div class="row">
            <h1>events</h1>
        </div>
        <?php

        $args = array(
            "post_type" => array( "events" ),
            "orderby"   => "date"
        );
        $slides = new WP_Query ( $args );
        while ( $slides->have_posts() ) : $slides->the_post();

        ?>

        <div class="event">
            <div class="date"><?php the_field( "event_date" ); ?></div>
            <div class="venue">
                <div class="name">
                    <?php the_field( "event_venue" ); ?>
                </div>
                <div class="locale">
                    <?php the_field( "event_location" ); ?>
                </div>
            </div>
            <div class="link">
                <a href="<?php the_field( "event_url" ); ?>" target="_blank">go</a>
            </div>
        </div>

        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
