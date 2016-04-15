<?php
    global $wp_query;

    $paged      = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $total_page = $wp_query->max_num_pages;
    $big        = 999999999; // need an unlikely integer

    $args = array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total'   => $total_page
    );

?>

<?php if ( $total_page > 1 ) : ?>
    <div class="paging">
        <?php echo paginate_links( $args ); ?>
        <span class="page-detail"><?php printf( __('Page %d of %d ', 'jeg_textdomain'), $paged, $total_page) ?></span>
    </div>
<?php endif ?>