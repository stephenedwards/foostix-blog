<?php get_header(); ?>

    <?php $show_sidebar = vp_option('joption.archives_show_sidebar', false); ?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">

            <?php
                get_template_part( 'include/archive-header' );

                if ( have_posts() ) :
                    get_template_part( 'include/archives', vp_option('joption.archives_content_layout', 'normal') );

                else : ?>

                    <!-- No Content Found -->
                    <article class="no-content short-content">
                        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'jeg_textdomain' ); ?></p>
                        <?php get_search_form(); ?>
                    </article>

                    <?php
                endif;
            ?>
        </div>
    </div>

<?php get_footer(); ?>