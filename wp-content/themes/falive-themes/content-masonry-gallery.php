<div class="article-masonry-container">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-masonry-box' ); ?> data-article-type="<?php echo get_post_format() ?>">
        <div class="article-masonry-wrapper clearfix">
            <?php get_template_part( 'include/postmeta' ); ?>
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

            <?php
            // query the gallery images meta
            $images = get_post_meta($post->ID, '_format_gallery_images', true);

            if ( $images && !empty($images) ) : ?>
                <div class="feature-holder galleries">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php foreach ( $images as $image_id ) :

                                $image = wp_get_attachment_image_src( $image_id, 'full' );
                                $thumbnail = wp_get_attachment_image_src( $image_id, 'half-featured' );

                                $attachment = get_post( $image_id );
                                $alt = trim(strip_tags( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true) ));
                                $image_title = $attachment->post_title; ?>

                                    <li><img alt="<?php echo (empty($alt) ? sanitize_title($image_title) : $alt) ?>" src="<?php  echo esc_url( $thumbnail[0] ) ?>"></li>

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            <?php elseif ( has_post_thumbnail() ) : ?>
                <div class="feature-holder">
                    <?php the_post_thumbnail('large') ?>
                </div>
            <?php endif; ?>

            <div class="article-masonry-summary">
                <?php the_excerpt(); ?>

                <?php if ( vp_option('joption.archives_show_readmore', 0) ) : ?>
                    <a href="<?php the_permalink(); ?>" class="readmore"><?php _e( 'Continue Reading', 'jeg_textdomain') ?> <span class="meta-nav">&rarr;</span></a>
                <?php endif; ?>
            </div>
        </div>
    </article>
</div>