<?php get_header(); ?>

    <?php $show_sidebar = vp_option('joption.archives_show_sidebar', false); ?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">
            <span class="line-heading-single"></span>
            <div class="post-container">
                <div class="main-post">
                <?php
                    // The Loop
                    if ( have_posts() ) :

                        while ( have_posts() ) : the_post();
                            get_template_part( 'content' );
                        endwhile;

                        // Pagination
                        jeg_pagination();

                    endif;
                ?>

                </div>

                <?php if ($show_sidebar )
                    get_sidebar();
                ?>

                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>