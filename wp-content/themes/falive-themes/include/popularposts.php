<?php
    $popularposts_count = vp_metabox('jeg_popularpost.jeg_popularposts_options.0.count', 10);
    $popularposts_column = vp_metabox('jeg_popularpost.jeg_popularposts_options.0.column', 4);
    $popularposts_autoplay = vp_metabox('jeg_popularpost.jeg_popularposts_options.0.autoplay', 0);
    $popularposts_delay = vp_metabox('jeg_popularpost.jeg_popularposts_options.0.delay', 5);

    $popular_posts = apply_filters('jeg_get_popular_posts', array(
        'limit' => $popularposts_count,
        'post_type' => 'post',
    ));

    if ( is_array($popular_posts) & !empty($popular_posts) ) {
?>
<!-- popular post -->

<div id="popular-post">
    <div class="container">
        <h2 class="line-heading">
            <span><?php _e('Trending Posts', 'jeg_textdomain') ?></span>
        </h2>
        <div id="popular-slider">
            <?php
            if ( is_array($popular_posts) & !empty($popular_posts) ) : foreach ($popular_posts as $post) : ?>
                <div class="item">
                    <?php if ( has_post_thumbnail( $post->id ) ) : ?>
                        <div class="feature-holder">
                            <a href="<?php echo get_permalink( $post->id ); ?>"><?php echo get_the_post_thumbnail( $post->id, 'popular-post' ) ?></a>
                        </div>
                    <?php else: ?>
                        <div class="feature-holder">
                            <a href="<?php echo get_permalink( $post->id ); ?>"><img src="<?php echo get_template_directory_uri(). "/images/placeholder_thumb.png" ?>" alt="<?php echo esc_html( $post->title ); ?>"></a>
                        </div>
                    <?php endif; ?>

                    <div class="popular-excerpt">
                        <span class="popular-category"><?php the_category(', ', null, $post->id); ?></span>
                        <h3><a href="<?php echo get_permalink( $post->id ); ?>"><?php echo esc_html( $post->title ); ?></a></h3>
                        <i><?php echo __('On ', 'jeg_textdomain') . get_the_date( 'F j, Y', $post->id ); ?></i>
                    </div>
                </div>
            <?php endforeach; endif; wp_reset_postdata(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    (function ($) {
        $(document).ready(function() {
            $("#popular-slider").owlCarousel({
                autoPlay: <?php echo esc_js( $popularposts_autoplay ? $popularposts_delay * 1000 : 'false' ); ?>,
                items : <?php echo esc_js( $popularposts_column ) ?>,
                itemsDesktop : [1199,3],
                itemsDesktopSmall : [979,3]
            });
        });
    })(jQuery);
</script>
<!-- popular post -->
<?php
    }
?>