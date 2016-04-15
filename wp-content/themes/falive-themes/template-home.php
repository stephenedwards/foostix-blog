<?php
/*
    Template Name: Homepage
*/
get_header();
?>

<?php
if ( ! post_password_required() ) :

    $paged      = jeg_get_query_paged();

    if($paged === 1) {
        if ( vp_metabox('jeg_slider.show_slider', true) )
            get_template_part( 'include/slider',  apply_filters('jeg_home_slider', vp_metabox('jeg_slider.slider_type', 'fullslider')) );

        if ( vp_metabox('jeg_popularpost.show_popularpost', true) && function_exists('wpp_get_mostpopular') )
            get_template_part( 'include/popularposts' );
    }

?>


<?php
        $show_sidebar = apply_filters('jeg_home_sidebar', vp_metabox('jeg_sidebar.show_sidebar', true));
        $page_ID = get_the_id();
?>

    <!-- content -->
    <div id="post-wrapper" class="<?php echo esc_attr($show_sidebar ? 'normal' : 'fullwidth'); ?>">
        <div class="container">
            <?php
                get_template_part( 'include/posts', apply_filters('jeg_home_layout', vp_metabox('jeg_blogcontent.layout', 'normal')) );
            ?>
        </div>
    </div>

<?php
else:
    get_template_part( 'password-form' );
endif;

get_footer();
?>