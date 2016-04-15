<?php

if ( has_category( '', $post->ID ) ) :
    $categories = get_the_category( $post->ID );
    $category_ids = array();
    foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;

    $args = array(
        'category__in'        => $category_ids,
        'post__not_in'        => array($post->ID),
        'showposts'           => 1,
        'ignore_sticky_posts' => 1
    );

    // The Query
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) : $the_query->the_post(); ?>

    <div class="related">
        <div class="arrow">
            <i class="fa fa-angle-left"></i>
        </div>
        <div class="content">
            <span><?php _e( 'Related Article', 'jeg_textdomain' ); ?></span>
            <a href="<?php the_permalink() ?>">
                <article>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="thumb"><?php the_post_thumbnail( 'popup-post' ) ?></div>
                    <?php endif; ?>

                    <div class="summary" style="">
                        <h2 class="heading" title="<?php echo esc_attr( get_the_title() ) ?>"><?php the_title() ?></h2>
                    </div>
                </article>
            </a>
        </div>
    </div>
    <div class="related-flag"></div>

    <?php endif;

    /* Restore original Post Data */
    wp_reset_postdata();
endif;
?>