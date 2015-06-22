<div class="news">
    <div class="container">
        <div class="row">
            <h1>news</h1>
        </div>


        <div class="row">
            <?php $index = 0; ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <?php

            $if_recent = ( $index < 3 );
            $image_size = ( $if_recent ? "news-feat-thumb" : "news-thumb" );
            $post_class = ( $if_recent ? "recent-post" : "prev-post" );

            ?>
            <div class="<?php echo $post_class; ?>">
                <?php the_post_thumbnail( $image_size ); ?>
                <?php the_title("<div class='title'>", "</div>"); ?>
                <div class="excerpt"><?php the_excerpt(); ?></div>
                <a class="permalink" href="<?php the_permalink(); ?>">read now</a>
            </div>
            <?php $index++; ?>
            <?php if ( $index === 3 ) : ?><div class="end-recent"></div><?php endif; ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</div>
