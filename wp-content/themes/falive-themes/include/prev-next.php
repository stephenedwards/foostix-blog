<div class="prevnext-post">
    <?php
    $prev_post = get_previous_post();
    if (empty( $prev_post )) $prev_post = 0;
    if (!empty( $prev_post )):
    ?>
    <a href="<?php echo get_permalink($prev_post->ID) ?>" class="post prev-post">
        <span class="caption"><?php _e('Prev Post', 'jeg_textdomain'); ?></span>
        <h3 class="post-title"><?php echo esc_html( $prev_post->post_title ) ?></h3>
    </a>
    <?php endif; ?>

    <?php
    $next_post = get_next_post();
    if (empty( $next_post )) $next_post = 0;
    if (!empty( $next_post )):
    ?>
    <a href="<?php echo get_permalink($next_post->ID) ?>" class="post next-post">
        <span class="caption"><?php _e('Next post', 'jeg_textdomain'); ?></span>
        <h3 class="post-title"><?php echo esc_html( $next_post->post_title ) ?></h3>
    </a>
    <?php endif; ?>

    <div class="clear"></div>
</div>