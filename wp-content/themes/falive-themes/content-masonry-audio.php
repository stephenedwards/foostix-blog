<div class="article-masonry-container">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-masonry-box' ); ?> data-article-type="<?php echo get_post_format() ?>">
        <div class="article-masonry-wrapper clearfix">
            <?php if ( vp_option('joption.archives_show_postmeta', 1) )
                get_template_part( 'include/postmeta' );
            ?>
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

            <div class="feature-holder audio">
                <?php if ( has_post_thumbnail() ) the_post_thumbnail('medium') ?>

                <?php
                    $audio_url = get_post_meta( $post->ID, '_format_audio_embed', true );
                    $audio_format = strtolower( pathinfo( $audio_url, PATHINFO_EXTENSION ) );

                    if ( in_array( $audio_format, array('mp3', 'ogg', 'wav') ) ) : ?>
                        <div data-mp3="<?php echo esc_url( $audio_url ) ?>" data-type="audio" class="audio-class"></div>
                    <?php endif;
                ?>
            </div>

            <div class="article-masonry-summary">
                <?php the_excerpt(); ?>

                <?php if ( vp_option('joption.archives_show_readmore', 0) ) : ?>
                    <a href="<?php the_permalink(); ?>" class="readmore"><?php _e( 'Continue Reading', 'jeg_textdomain') ?> <span class="meta-nav">&rarr;</span></a>
                <?php endif; ?>
            </div>
        </div>
    </article>
</div>