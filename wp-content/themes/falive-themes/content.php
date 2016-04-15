<?php
    global $page_ID;

    // global excerpt setting
    add_filter( 'excerpt_length', 'jeg_home_excerpt_length', 999 );
    add_filter('excerpt_more', 'jeg_home_excerpt_more');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( jeg_post_class($page_ID) ); ?> data-article-type="<?php echo get_post_format() ?>">
    <div class="content-header-single">
        <?php if ( vp_option('joption.archives_show_postmeta', 1) )
            get_template_part( 'include/postmeta' );
        ?>

        <h2 class="content-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>

        <span class="content-separator"></span>

       <?php get_template_part( 'include/featured-content' ); ?>
    </div>

    <div class="entry">
        <?php if ( ((is_archive() || is_search() || is_home()) && vp_option('joption.archives_content_type', 'excerpt') == 'full')
                 || (is_page_template( 'template-home.php' ) && vp_metabox('jeg_blogcontent.content_type', 'excerpt', $page_ID) == 'full') ) :

            the_content( __('Continue Reading', 'jeg_textdomain') );

        else :
            the_excerpt();
            if ( vp_option('joption.archives_show_readmore', 0) ) : ?>
                <div class="readmore-wrap">
                    <a href="<?php the_permalink(); ?>" class="readmore"><?php _e( 'Continue Reading', 'jeg_textdomain') ?></a>
                </div>
            <?php endif;
        endif; ?>
    </div>

    <?php if ( vp_option('joption.archives_show_socials', 1) )
        get_template_part( 'include/socialshare' );
    ?>
</article>

<?php
    remove_filter('excerpt_length', 'jeg_home_excerpt_length');
    remove_filter('excerpt_more', 'jeg_home_excerpt_more');
?>