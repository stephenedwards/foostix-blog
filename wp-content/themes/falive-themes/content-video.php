<article id="post-<?php the_ID(); ?>" <?php post_class( jeg_post_class() ); ?> data-article-type="html5video">
    <?php if ( vp_option('joption.archives_show_postmeta', 1) )
        get_template_part( 'include/postmeta' );
    ?>

    <h2 class="content-title">
        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h2>

    <div class="feature-holder video">

        <?php
            $video_url      = get_post_meta( $post->ID, '_format_video_embed', true );
            $video_format   = strtolower( pathinfo( $video_url, PATHINFO_EXTENSION ) );
            $featured_img   = jeg_get_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        ?>

        <?php if ( jeg_video_type($video_url) === 'youtube' ) : ?>
            <div data-src="<?php echo esc_url( $video_url ) ?>" data-type="youtube" data-repeat="false" data-autoplay="false" class="youtube-class"><div class="video-container"></div></div>

        <?php elseif ( jeg_video_type($video_url) === 'vimeo'  ) : ?>
            <div data-src="<?php echo esc_url( $video_url ) ?>" data-repeat="false" data-autoplay="false" data-type="vimeo" class="vimeo-class"><div class="video-container"></div></div>

        <?php elseif ( wp_oembed_get( $video_url ) ) : ?>
            <div class="video-container"><?php echo wp_oembed_get( $video_url ); ?></div>

        <?php elseif ( $video_format == 'mp4' ) : ?>
            <video width="640" height="400" style="width: 100%; height: 100%;" poster="<?php echo esc_attr( $featured_img ) ?>" preload="none">
                <source type="video/mp4" src="<?php echo esc_url( $video_url ) ?>">
            </video>

        <?php endif; ?>

    </div>

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
