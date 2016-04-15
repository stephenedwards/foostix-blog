<?php
    $sidebar_name = JEG_SIDEBAR_WIDGET;

    if ( is_page_template( 'template-home.php' ) ) {
        $sidebar_name = vp_metabox('jeg_sidebar.sidebar_name', JEG_SIDEBAR_WIDGET);
    } elseif ( is_single() ) {
        $sidebar_name = vp_option('joption.single_sidebar_name', JEG_SIDEBAR_WIDGET);
    } elseif ( is_page() ) {
        $sidebar_name = vp_option('joption.page_sidebar_name', JEG_SIDEBAR_WIDGET);
    } else {
        $sidebar_name = vp_option('joption.archives_sidebar_name', JEG_SIDEBAR_WIDGET);
    }
?>

<?php if ( is_active_sidebar( $sidebar_name ) ) { ?>
<div class="sidebar">
    <div class="sidebar-container">
        <?php dynamic_sidebar( $sidebar_name ); ?>
    </div>
</div>
<?php } ?>