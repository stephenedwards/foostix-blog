<?php
// Post: Gallery
if ( get_post_format() == 'gallery' ) :
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
            <?php if (is_single()) : ?>
                <?php the_post_thumbnail('featured') ?>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('featured') ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php
// Post: Video
elseif ( get_post_format() == 'video' ) : ?>
    <div class="feature-holder video">
        <?php
            $video_url      = get_post_meta( $post->ID, '_format_video_embed', true );
            $video_format   = strtolower( pathinfo( $video_url, PATHINFO_EXTENSION ) );
            $featured_img   = jeg_get_image_src( get_post_thumbnail_id( $post->ID ), 'featured' );
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

<?php
// Post: Video
elseif ( get_post_format() == 'audio' ) :
    $audio_url = get_post_meta( $post->ID, '_format_audio_embed', true );
    if (strpos($audio_url,'soundcloud.com') !== false) {
?>
    <div class="feature-holder video">
        <div data-src="<?php echo esc_url( $audio_url ) ?>" data-type="soundcloud" data-repeat="false" data-autoplay="false" class="soundcloud-class"><div class="music-container"></div></div>
    </div>
<?php
    } else {
?>
    <div class="feature-holder audio">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php if (is_single()) : ?>
                <?php the_post_thumbnail('featured') ?>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('featured') ?></a>
            <?php endif;
        endif; ?>

        <?php
            $audio_format = strtolower( pathinfo( $audio_url, PATHINFO_EXTENSION ) );

            if ( in_array( $audio_format, array('mp3', 'ogg', 'wav') ) ) : ?>
                <div data-mp3="<?php echo esc_url( $audio_url ) ?>" data-type="audio" class="audio-class"></div>
            <?php endif;
        ?>
    </div>
<?php
    }
// Post: Standard
elseif ( has_post_thumbnail() ) : ?>
    <div class="feature-holder">
        <?php if (is_single()) : ?>
            <?php the_post_thumbnail('featured') ?>
        <?php else: ?>
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('featured') ?></a>
        <?php endif; ?>
    </div>
<?php endif; ?>