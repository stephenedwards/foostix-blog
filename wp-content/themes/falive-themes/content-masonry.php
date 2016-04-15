<?php
add_filter( 'excerpt_length', 'jeg_home_masonry_excerpt_length', 999 );
add_filter('excerpt_more', 'jeg_home_excerpt_more');
?>
<div class="article-masonry-container">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'article-masonry-box' ); ?>>
        <div class="article-masonry-wrapper clearfix">

            <?php get_template_part( 'include/featured-content-masonry' ); ?>
            <div class="content-meta">
                <span class="meta-category"><?php the_category(', '); ?></span>
            </div>
            <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="article-masonry-summary">
                <?php the_excerpt(); ?>

                <?php if ( vp_option('joption.archives_show_readmore', 0) ) : ?>
                    <a href="<?php the_permalink(); ?>" class="readmore"><?php _e( 'Continue Reading', 'jeg_textdomain') ?> <span class="meta-nav">&rarr;</span></a>
                <?php endif; ?>
            </div>
        </div>
    </article>
</div>
<?php
remove_filter('excerpt_length', 'jeg_home_masonry_excerpt_length');
remove_filter('excerpt_more', 'jeg_home_excerpt_more');
?>