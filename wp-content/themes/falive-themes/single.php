<?php get_header(); ?>

    <?php $show_sidebar = apply_filters('jeg_post_sidebar', vp_option('joption.single_show_sidebar', false)); ?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">
            <span class="line-heading-single"></span>
            <div class="post-container">
                <div class="main-post">
                <?php
                    while ( have_posts() ) : the_post();

                        /* Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'content' , 'single' );

                    if ( has_tag() && vp_option( 'joption.single_show_tags', 1 ) ) : ?>
                        <div class="tag-wrapper">
                            <i class="fa fa-tag"></i>
                            <strong><?php _e( 'Article Tags : ', 'jeg_textdomain' ); ?></strong>
                            <?php the_tags('', ', '); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                        if ( vp_option('joption.single_show_socials', 1) ) get_template_part( 'include/socialshare' );
                        if(!vp_option('joption.hide_next_prev_post', 0)) get_template_part('include/prev-next');
                        if ( vp_option('joption.single_show_popuppost', 1) ) get_template_part( 'include/popup-post' );
                        if ( vp_option( 'joption.single_show_authorbox', 1 ) && !post_password_required() ) get_template_part( 'include/authorbox' );
                        if( !vp_option('joption.hide_related_post_bottom', 0)) get_template_part('include/post-related');
                        if ( !vp_option( 'joption.single_disable_comment', 0 ) && (comments_open() || '0' != get_comments_number() ) )
                            comments_template();
                    endwhile;
                    ?>

                </div>

                <?php if ($show_sidebar ) get_sidebar(); ?>

                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>