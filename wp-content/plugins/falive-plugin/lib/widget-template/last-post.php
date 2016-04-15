<div class="latest-post">
    <ul>
<?php
    $number = empty ( $lastnumber ) ? 4 : $lastnumber ;
    $query = new WP_Query(array(
        'post_type'				=> "post",
        'orderby'				=> "date",
        'order'					=> "DESC",
        'posts_per_page'		=> $number
    ));

    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
?>
    <li>
        <div class="latest-post-item">
            <?php if(has_post_thumbnail(get_the_ID())) { ?>
                <div class="feature-holder">
                    <a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'popular-post' ) ?></a>
                </div>
            <?php } else { ?>
                <div class="feature-holder">
                    <a href="<?php echo get_permalink( get_the_ID() ); ?>"><img src="<?php echo get_template_directory_uri(). "/images/placeholder_thumb.png" ?>" alt="<?php the_title(); ?>"></a>
                </div>
            <?php } ?>
            <div class="feature-summary">
                <h3>
                    <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <i><?php echo __('On ', 'jeg_textdomain') . get_the_date( 'F j, Y', get_the_ID() ); ?></i>
            </div>
            <div class="clear"></div>
        </div>
    </li>
<?php
        }
    }
    wp_reset_postdata();
?>
    </ul>
</div>