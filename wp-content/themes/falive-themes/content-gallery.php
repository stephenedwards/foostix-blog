<article id="post-<?php the_ID(); ?>" <?php post_class( jeg_post_class() ); ?> data-article-type="<?php echo get_post_format() ?>">
    <?php if ( vp_option('joption.archives_show_postmeta', 1) )
        get_template_part( 'include/postmeta' );
    ?>

    <h2 class="content-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h2>

    <?php
    // query the gallery images meta
    $images = get_post_meta($post->ID, '_format_gallery_images', true);

    if ( $images && !empty($images) ) : ?>
        <div class="feature-holder galleries">
            <div class="flexslider">
                <ul class="slides">
                    <?php foreach ( $images as $image_id ) :

                        $image = jeg_get_image_src( $image_id, 'featured' );
                        $attachment = get_post( $image_id );
                        $alt = trim(strip_tags( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true) ));
                        $image_title = $attachment->post_title; ?>

                        <li><img alt="<?php echo (empty($alt) ? sanitize_title($image_title) : $alt) ?>" src="<?php  echo esc_url( $image ) ?>"></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    <?php elseif ( has_post_thumbnail() ) : ?>
        <div class="feature-holder">
            <?php the_post_thumbnail('large') ?>
        </div>
    <?php endif; ?>

    <div class="entry">
        <?php if ( vp_option('joption.archives_content_type', 'excerpt') == 'excerpt' ) :

            the_excerpt();

            if ( vp_option('joption.archives_show_readmore', 0) ) : ?>
                <a href="<?php the_permalink(); ?>" class="readmore"><?php _e( 'Continue Reading', 'jeg_textdomain') ?></a>
            <?php endif;

        else :
            the_content( __('Continue Reading', 'jeg_textdomain') );
        endif; ?>
    </div>

    <?php if ( vp_option('joption.archives_show_socials', 1) )
        get_template_part( 'include/socialshare', $name );
    ?>
</article>