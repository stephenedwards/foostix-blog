<article id="post-<?php the_ID(); ?>" <?php post_class( jeg_post_class() ); ?> data-article-type="<?php echo get_post_format() ?>">
    <div class="content-header-single">
        <?php if ( vp_option('joption.single_show_postmeta', 1) )
            get_template_part( 'include/postmeta' ); ?>

        <h1 class="content-title"><?php the_title(); ?></h1>

        <span class="content-separator"></span>

        <?php get_template_part( 'include/featured-content' ); ?>
    </div>

    <?php
    if(vp_option('joption.show_related_post', 0)) {
        echo jeg_relatedpost(array(
            'size' => vp_option('joption.related_post_number', 4)
        ));
    }
    ?>
    <div class="entry clearfix">
        <?php
            the_content();
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'jeg_textdomain' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
            ) );
        ?>
    </div>
</article>