<div class="content-meta">
    <span class="meta-author"><?php _e( 'By', 'jeg_textdomain' ) ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo jeg_get_author_name(); ?></a></span>
    <span class="meta-date"><?php echo esc_html(get_the_date());  ?></span>
    <span class="meta-category"><?php _e( 'in', 'jeg_textdomain' ) ?> <?php the_category(', '); ?></span>
    <span class="meta-comment"><?php comments_popup_link( __( 'No Comments', 'jeg_textdomain' ), __( '1 Comment', 'jeg_textdomain' ), __( '% Comments', 'jeg_textdomain' ) ); ?></span>
</div>