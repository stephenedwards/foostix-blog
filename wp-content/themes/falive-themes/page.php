<?php get_header(); ?>

    <?php $show_sidebar = vp_option('joption.page_show_sidebar', false); ?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">
            <span class="line-heading-single"></span>
            <div class="post-container">
                <div class="main-post">

                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'full-content enable-pin-share' ); ?>>
                            <div class="content-header-single">
                                <h1 class="content-title"><?php the_title(); ?></h1>

                                <span class="content-separator"></span>

                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="feature-holder">
                                        <?php the_post_thumbnail('large') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

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
                    <?php endwhile; ?>

                    <?php
                        if ( vp_option('joption.page_show_socials', 1) )
                            get_template_part( 'include/socialshare' );

                        if ( !vp_option( 'joption.page_disable_comment', 0 ) && (comments_open() || '0' != get_comments_number() ) )
                            comments_template();
                    ?>

                </div>

                <?php if ($show_sidebar ) get_sidebar(); ?>

                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>