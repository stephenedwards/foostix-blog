<?php $featured_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
<div class="sharing-wrapper bottom circle">
    <?php if (is_singular()) : ?>
        <div class="meta-article-header">
            <span><?php _e( 'Share this article', 'jeg_textdomain' ); ?></span>
        </div>
    <?php endif; ?>

    <div class="sharing">
        <div class="sharing-facebook">
            <a data-shareto="<?php _e('Facebook', 'jeg_textdomain') ?>" rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_get_shortlink() ?>"><i class="fa fa-facebook"></i></a>
        </div>
        <div class="sharing-twitter">
            <a data-shareto="<?php _e('Twitter', 'jeg_textdomain') ?>" rel="nofollow" target="_blank" href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() ); ?>%20-%20<?php echo wp_get_shortlink() ?>"><i class="fa fa-twitter"></i></a>
        </div>
        <div class="sharing-google">
            <a data-shareto="<?php _e('Google', 'jeg_textdomain') ?>" rel="nofollow" target="_blank" href="https://plus.google.com/share?url=<?php echo wp_get_shortlink() ?>"><i class="fa fa-google"></i></a>
        </div>
        <div class="sharing-pinterest">
            <a data-shareto="<?php _e('Pinterest', 'jeg_textdomain') ?>" rel="nofollow" target="_blank" href="#" data-href="https://pinterest.com/pin/create/button/?url=<?php echo wp_get_shortlink() ?>&amp;media=<?php echo esc_url( $featured_img ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>"><i class="fa fa-pinterest"></i></a>
        </div>
        <div class="sharing-linkedin">
            <a data-shareto="<?php _e('Linkedin', 'jeg_textdomain') ?>" rel="nofollow" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo wp_get_shortlink() ?>&amp;title=<?php echo urlencode( get_the_title() ) ?>&amp;summary=<?php echo urlencode( wp_strip_all_tags( get_the_excerpt() )) ?>&amp;source=<?php echo urlencode( get_bloginfo( 'name' ) ) ?>"><i class="fa fa-linkedin"></i></a>
        </div>
    </div>


    <?php if (!is_singular()) : ?>
        <div class="meta-article-header">
            <span><?php _e( 'Share this article', 'jeg_textdomain' ); ?></span>
        </div>
    <?php endif; ?>
</div>