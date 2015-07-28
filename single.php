<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class("container"); ?>>
        <div class="row">
            <div class="logo">Damien Palace</div>
        </div>
        <div class="row">
            <figure>
                <?php the_post_thumbnail(); ?>
            </figure>
        </div>
        <div class="row">
            <aside>
                <h1><?php the_time( "M j" ); ?></h1>
            </aside>
            <section class="content">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </section>
        </div>
        <div class="row">
            <?php $prev_post = get_previous_post(); $next_post = get_next_post(); ?>
            <div id="adjacent-posts">
                <div class="row">
                    <div class="prev">
                        <?php if( !empty( $prev_post ) ): ?>
                            <?php echo get_the_post_thumbnail( $prev_post->ID, "post-pagination-thumb" ); ?>
                            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                                <span>prev project</span>
                                <?php echo $prev_post->post_title; ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="next">
                        <?php if( !empty( $next_post ) ): ?>
                            <?php echo get_the_post_thumbnail( $next_post->ID, "post-pagination-thumb" ); ?>
                            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                                <span>next project</span>
                                <?php echo $next_post->post_title; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <section id="comment-section">
                <?php comments_template(); ?>
            </section>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
