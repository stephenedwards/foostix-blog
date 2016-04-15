<?php

if ( has_category() ) :
    $categories = get_the_category();
    $category_ids = array();
    foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;

    $show_sidebar = vp_option('joption.single_show_sidebar', true);
    $posttotal = $show_sidebar ? 4 : 5;
    $grid = $show_sidebar ? "grid one-forth" : " grid one-fifth";

    $args = array(
        'category__in'        => $category_ids,
        'showposts'           => $posttotal,
        'ignore_sticky_posts' => 1,
        'post__not_in'        => array(get_the_ID())
    );

    // The Query
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
        ?>

        <div id="related-post">
            <div class="meta-article-header">
                <span><?php _e('Related Posts', 'jeg_textdomain') ?></span>
            </div>
            <div class="related-post-bottom">
            <?php
                $index = 0;
                while ( $the_query->have_posts() ) :
                    $the_query->the_post();
                    $index++;
                    if($index === $posttotal) $grid .= " last";
                    ?>
                    <div class="<?php echo esc_attr($grid); ?> item">
                        <?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
                            <div class="feature-holder">
                                <a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'popular-post' ) ?></a>
                            </div>
                        <?php else: ?>
                            <div class="feature-holder">
                                <a href="<?php echo get_permalink( get_the_ID() ); ?>"><img src="<?php echo get_template_directory_uri(). "/images/placeholder_thumb.png" ?>" alt="<?php the_title(); ?>"></a>
                            </div>
                        <?php endif; ?>
                        <div class="related-excerpt">
                            <h3><a href="<?php echo get_permalink( $post->id ); ?>"><?php the_title(); ?></a></h3>
                            <i><?php echo __('On ', 'jeg_textdomain') . get_the_date( 'F j, Y', get_the_ID() ); ?></i>
                        </div>
                    </div>
                    <?php
                endwhile;
            ?>
                <div class="clear"></div>
            </div>

        </div>

    <?php
    endif;
    wp_reset_postdata();
endif;

?>