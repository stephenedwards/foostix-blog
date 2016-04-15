<?php
global $post;

if ( post_password_required() ) return; ?>

<div id="comments" class="comment-wrapper">

    <?php if ( have_comments() ) : ?>
        <h3 class="heading">
            <?php printf ( _n ( 'Discussion about this %1$s', '%2$s Discussion to this %1$s', get_comments_number(), 'jeg_textdomain' ) , $post->post_type, number_format_i18n(get_comments_number()) ); ?>
        </h3>

        <ol class="commentlist">
            <?php wp_list_comments( array( 'avatar_size' => '80' ) ); ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <div class="comment-navigation navigation" >
                <div class='alignleft' style="margin-bottom: 20px;">
                    <?php next_comments_link('<span>&laquo;</span> Previous') ?>
                </div>
                <div class='alignright' style="margin-bottom: 20px;">
                    <?php previous_comments_link('Next<span>&raquo;</span>') ?>
                </div>
            </div>
        <?php endif;  ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'jeg_textdomain' ); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div>