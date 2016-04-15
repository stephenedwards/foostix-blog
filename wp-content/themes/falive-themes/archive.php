<?php get_header(); ?>

    <?php $show_sidebar = vp_option('joption.archives_show_sidebar', false); ?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">

            <?php get_template_part( 'include/archive-header' ) ?>

            <?php
                get_template_part( 'include/archives', vp_option('joption.archives_content_layout', 'normal') );
            ?>
        </div>
    </div>

<?php get_footer(); ?>