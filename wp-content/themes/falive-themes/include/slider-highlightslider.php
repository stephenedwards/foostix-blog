<?php

    $post_count = vp_metabox('jeg_slider.slider_post_count', 5);
    $post_categories = vp_metabox('jeg_slider.slider_filter_categories', array());
    $post_tags = vp_metabox('jeg_slider.slider_filter_tags', array());

    $slider_animation = vp_metabox('jeg_slider.jeg_slider_highlightslider_options.0.animation', 'slide');
    $slider_delay = vp_metabox('jeg_slider.jeg_slider_highlightslider_options.0.delay', 7);
    $slider_autoplay = vp_metabox('jeg_slider.jeg_slider_highlightslider_options.0.autoplay', false);

    $statement = array(
        'posts_per_page'    => $post_count,
        'meta_key'          => '_thumbnail_id',
    );

    if(!empty($post_categories)) $statement['category__and'] = implode(",", $post_categories);
    if(!empty($post_tags) && jeg_check_tag_post($post_tags)) $statement['tag__and'] = implode(",", $post_tags);



    $query = new WP_Query($statement);


    add_filter('excerpt_length', 'jeg_slider_excerpt');
    add_filter('excerpt_more', 'jeg_slider_latest_more');

    // The Loop
    if ( $query->have_posts() ) :
?>

    <!-- Slider: Highlightslider -->
    <div id="slider" class="highlightslider">
        <div class="container">
            <div class="flexslider">
                <ul class="slides">

                <?php while ( $query->have_posts() ) : $query->the_post(); if (has_post_thumbnail()) : ?>
                    <li>
                        <article>
                            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'featured' ); ?></a>
                            <div class="slide-overlay">
                                <div class="slider-excerpt">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="line"></div>
                                    <?php the_excerpt(); ?>
                                    <a class="readmore" href="<?php the_permalink() ?>"><?php _e( 'Read More', 'jeg_textdomain' ); ?></a>
                                </div>
                            </div>
                        </article>
                    </li>
                <?php endif; endwhile; ?>

                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        (function ($) {
            $(document).ready(function(){
                $('.highlightslider .flexslider').flexslider({
                    animation: '<?php echo esc_js($slider_animation) ?>',
                    slideshow: <?php echo esc_js($slider_autoplay) ?>,
                    slideshowSpeed: <?php echo esc_js( $slider_delay * 1000 ) ?>,
                    startAt: 0,
                    controlNav: false,
                    mousewheel: false
                });
            });
        })(jQuery);
    </script>
    <!-- Slider: Highlightslider ended -->

<?php
    else:
        // no posts found
    endif;

    remove_filter('excerpt_length', 'jeg_slider_excerpt');
    remove_filter('excerpt_more', 'jeg_slider_latest_more');

    /* Restore original Post Data */
    wp_reset_postdata();
?>