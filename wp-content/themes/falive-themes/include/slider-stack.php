<?php

    $post_count = 5;
    $post_categories = vp_metabox('jeg_slider.slider_filter_categories', array());
    $post_tags = vp_metabox('jeg_slider.slider_filter_tags', array());

    $statement = array(
        'posts_per_page'    => $post_count,
        'meta_key'          => '_thumbnail_id',
    );

    if(!empty($post_categories)) $statement['category__in'] = $post_categories;
    if(!empty($post_tags)) $statement['tags__in'] = $post_tags;

    $query = new WP_Query($statement);

    // The Loop
    if ( $query->have_posts() ) :

        $i = 1;
        $slider_posts = array();
        while ( $query->have_posts() ) : $query->the_post(); if (has_post_thumbnail() && $i <= 5) :
            $slider_posts[ $i ] = $post;
            $slider_posts[ $i ]->image = jeg_get_image_src( get_post_thumbnail_id( $post->ID ), 'featured' );

            $get_cats = get_the_category( $post->ID );
            $total_category = count($get_cats);
            $categories = '';
            $cat_index = 1;

            foreach ( $get_cats as $category ) :
                if ( $cat_index < $total_category )
                    $categories .= '<strong>'. $category->cat_name .'</strong>, ';
                else
                    $categories .= '<strong>'. $category->cat_name .'</strong>';

                $cat_index++;
            endforeach;

            $slider_posts[ $i ]->categories = $categories;

            $i++;
        endif; endwhile;
?>

<div class="container">
    <div class="stackcontent">
        <div class="firststack parentstack">
            <div class="firststack-first childstack">
            <?php if ( isset($slider_posts[1]) ) : ?>
                <a href="<?php echo get_permalink( $slider_posts[1]->ID ); ?>">
                    <div class="stackbg" style="background-image: url('<?php echo $slider_posts[1]->image; ?>');"></div>
                    <div class="stackwrapper">
                        <h2><?php echo $slider_posts[1]->post_title;?></h2>
                        <div class="stackmeta">
                            <?php _e( 'By', 'jeg_textdomain' ) ?> <strong><?php echo jeg_get_author_name( $slider_posts[1]->post_author ); ?></strong>
                            <?php _e( 'in', 'jeg_textdomain' ) ?> <?php echo $slider_posts[1]->categories ?>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
            </div>
            <div class="firststack-second childstack">
                <?php if ( isset($slider_posts[2]) ) : ?>
                <a href="<?php echo get_permalink( $slider_posts[2]->ID ); ?>">
                    <div class="stackbg" style="background-image: url('<?php echo $slider_posts[2]->image; ?>');"></div>
                    <div class="stackwrapper">
                        <h2><?php echo $slider_posts[2]->post_title;?></h2>
                        <div class="stackmeta">
                            <?php _e( 'By', 'jeg_textdomain' ) ?> <strong><?php echo jeg_get_author_name( $slider_posts[2]->post_author ); ?></strong>
                            <?php _e( 'in', 'jeg_textdomain' ) ?> <?php echo $slider_posts[2]->categories ?>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="secondstack parentstack">
            <div class="secondstack-first childstack">
                <?php if ( isset($slider_posts[3]) ) : ?>
                <a href="<?php echo get_permalink( $slider_posts[3]->ID ); ?>">
                    <div class="stackbg" style="background-image: url('<?php echo $slider_posts[3]->image; ?>');"></div>
                    <div class="stackwrapper">
                        <h2><?php echo $slider_posts[3]->post_title;?></h2>
                        <div class="stackmeta">
                            <?php _e( 'By', 'jeg_textdomain' ) ?> <strong><?php echo jeg_get_author_name( $slider_posts[3]->post_author ); ?></strong>
                            <?php _e( 'in', 'jeg_textdomain' ) ?> <?php echo $slider_posts[3]->categories ?>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <div class="secondstack-second childstack">
                <?php if ( isset($slider_posts[4]) ) : ?>
                <a href="<?php echo get_permalink( $slider_posts[4]->ID ); ?>">
                    <div class="stackbg" style="background-image: url('<?php echo $slider_posts[4]->image; ?>');"></div>
                    <div class="stackwrapper">
                        <h2><?php echo $slider_posts[4]->post_title;?></h2>
                        <div class="stackmeta">
                            <?php _e( 'By', 'jeg_textdomain' ) ?> <strong><?php echo jeg_get_author_name( $slider_posts[4]->post_author ); ?></strong>
                            <?php _e( 'in', 'jeg_textdomain' ) ?> <?php echo $slider_posts[4]->categories ?>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <div class="secondstack-third childstack">
                <?php if ( isset($slider_posts[5]) ) : ?>
                <a href="<?php echo get_permalink( $slider_posts[5]->ID ); ?>">
                    <div class="stackbg" style="background-image: url('<?php echo $slider_posts[5]->image; ?>');"></div>
                    <div class="stackwrapper">
                        <h2><?php echo $slider_posts[5]->post_title;?></h2>
                        <div class="stackmeta">
                            <?php _e( 'By', 'jeg_textdomain' ) ?> <strong><?php echo jeg_get_author_name( $slider_posts[5]->post_author ); ?></strong>
                            <?php _e( 'in', 'jeg_textdomain' ) ?> <?php echo $slider_posts[5]->categories ?>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<?php
    else:
        // no posts found
    endif;

    /* Restore original Post Data */
    wp_reset_postdata();
?>