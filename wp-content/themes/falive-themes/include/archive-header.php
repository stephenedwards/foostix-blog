<div class="category-header">
<?php

    $heading = '';
    $content = '';

    if ( is_day() ) :
        $heading = sprintf( __( 'Daily Archives', 'jeg_textdomain' ) );
        $content = get_the_date();
    elseif ( is_month() ) :
        $heading = sprintf( __( 'Monthly Archives', 'jeg_textdomain' ) );
        $content = get_the_date( _x( 'F Y', 'monthly archives date format', 'jeg_textdomain' ) );
    elseif ( is_year() ) :
        $heading = sprintf( __( 'Yearly Archives', 'jeg_textdomain' ));
        $content = get_the_date( _x( 'Y', 'yearly archives date format', 'jeg_textdomain' ) );
    elseif ( is_category() ) :
        $heading = sprintf( __( 'Posts in Category', 'jeg_textdomain' ));
        $content = single_cat_title( '', false );
    elseif ( is_tag() ) :
        $heading = sprintf( __( 'Posts in Tag', 'jeg_textdomain' ));
        $content = single_tag_title( '', false );
    elseif ( is_search() ) :
        $heading = sprintf( __( 'Search Result For', 'jeg_textdomain' ));
        $content = get_search_query();
    elseif ( is_author() ) :
        $heading = sprintf( __( 'All posts by', 'jeg_textdomain' ) );
        $content = jeg_get_author_name();
    else :
        $heading = __( 'Archives', 'jeg_textdomain' );
    endif;
?>
    <span><?php echo esc_html( $heading ); ?></span>
    <h2><?php echo esc_html($content); ?></h2>
</div>